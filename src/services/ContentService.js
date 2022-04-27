import axios from 'axios'
import store from '@/store/index.js'
import LogService from '@/services/LogService.js'

const log = process.env.VUE_APP_SITE_SHOW_CONSOLE_LOG
const apiURL = process.env.VUE_APP_DEFAULT_SITES_URL
const apiLocation = process.env.VUE_APP_SITE_LOCATION
//const apiLocation = 'author'
const postDestination = 'AuthorApi.php?location=' + apiLocation
const apiSELECT = axios.create({
  baseURL: apiURL,
  withCredentials: false, // This is the default
  crossDomain: true,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
})

// I want to export a JSON.stringified of response.data.text
export default {
  async getBiblePassage(params) {
    params.action = 'getBiblePassage'
    return await this.aReturnResponse(params)
  },
  async get(action, params) {
    params.action = 'get/' + action
    return await this.aReturnResponse(params)
  },

  consoleLog(params, response) {
    if (log == true) {
      if (params.action !== 'login') {
        console.log(params)
        console.log(response)
      }
    }
  },
  async zReturnResponse(params) {
    try {
      var contentForm = this.toAuthorizedFormData(params)
      var response = await apiSELECT.post(postDestination, contentForm)
      params.function = 'aReturnContentParsed'
      LogService.consoleLog('aReturnResponse', params, response)
      if (response.data.login) {
        alert('Author Service is pushing you to login')
        this.$router.push({
          name: 'login',
        })
      }
      return response
    } catch (error) {
      this.error = error.toString() + ' ' + params.action
      LogService.consoleLogError(
        'something went wrong',
        this.error,
        'aReturnResponse'
      )
      return 'error'
    }
  },
  async zReturnContent(params) {
    try {
      var content = {}
      var contentForm = this.toAuthorizedFormData(params)
      var response = await apiSELECT.post(postDestination, contentForm)
      params.function = 'aReturnContent'
      this.consoleLog(params, response)
      if (response.data.login) {
        alert('Author Service is pushing you to login')
        this.$router.push({
          name: 'login',
        })
      }
      //this.clearActionAndPage()
      if (typeof response.data !== 'undefined') {
        console.log(' have data content')
        content = response.data
      } else if (typeof response !== 'undefined') {
        console.log(' have  content')
        content = response
      }
      //this.clearActionAndPage()
      return content
    } catch (error) {
      this.error = error.toString() + ' ' + params.action
      LogService.consoleLogError(
        'something went wrong',
        this.error,
        'aReturnContent'
      )
      return 'error'
    }
  },
  async zReturnContentParsed(params) {
    try {
      var parse = {}
      var contentForm = this.toAuthorizedFormData(params)
      var response = await apiSELECT.post(postDestination, contentForm)
      params.function = 'aReturnContentParsed'
      this.consoleLog(params, response)
      if (response.data.login) {
        alert('Author Service is pushing you to login')
        this.$router.push({
          name: 'login',
        })
      }
      if (response.data) {
        parse = JSON.parse(response.data)
      }
      //this.clearActionAndPage()
      return parse
    } catch (error) {
      this.error = error.toString() + ' ' + params.action
      LogService.consoleLogError(
        'something went wrong',
        this.error,
        'aReturnContentParsed'
      )
      return 'error'
    }
  },
  async zReturnData(params) {
    try {
      var data = {}
      var contentForm = this.toAuthorizedFormData(params)
      var response = await apiSELECT.post(postDestination, contentForm)
      console.log(response)
      params.function = 'aReturn'
      this.consoleLog(params, response)
      if (response.data.login) {
        alert('Author Service is pushing you to login')
        this.$router.push({
          name: 'login',
        })
      }
      if (response.data) {
        data = response.data
      }
      //this.clearActionAndPage()
      return data
    } catch (error) {
      this.error = error.toString() + ' ' + params.action
      LogService.consoleLogError(
        'something went Wrong',
        this.error,
        'aReturnData'
      )
      return 'error'
    }
  },

  toAuthorizedFormData(params) {
    params.my_uid = store.state.user.uid
    params.token = store.state.user.token
    var form_data = new FormData()
    for (var key in params) {
      form_data.append(key, params[key])
    }
    // Display the key/value pairs
    // for (var pair of form_data.entries()) {
    //  this.consoleLog(params, pair[0] + ', ' + pair[1])
    //}
    //this.consoleLog(params, form_data)
    return form_data
  },
  async updateUser(params) {
    params.page = 'updateUser'
    params.action = 'updateUser'
    return this.aReturnResponse(params)
  },
}

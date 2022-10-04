<template>
  <div id="nav">
    <router-link to="/">Front</router-link> |
    <router-link to="/discuss">Discuss</router-link> |
    <router-link to="/read">Read the Bible</router-link> |
    <router-link to="/listen">Listen</router-link>|
    <router-link to="/watch">Watch</router-link> |
    <router-link to="/ask">Ask</router-link> |
    <router-link to="/meet">Meet God</router-link> |
    <router-link to="/spirit">Adventure</router-link> |
    <router-link to="/link">Link</router-link> |
  </div>
  <router-view />
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
.content {
  text-align: left;
}
</style>

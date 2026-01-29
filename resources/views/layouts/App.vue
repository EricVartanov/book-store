<template>
  <div class="app">
    <header class="header">
      <nav class="header-nav">
        <Link class="header-nav-link" to="/">Домой</Link>
        <Link class="header-nav-link" to="/about-us">О Нас</Link>
      </nav>
    </header>
    <main class="main">
      <slot/>
    </main>
    <footer>

    </footer>
  </div>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";

</script>


<style>
* {
  box-sizing: border-box;
}

body {
  background-color: rgb(228, 226, 223);
  margin: 0 !important;
}

h1, h2, h3, h4, h5, h6 {
  margin: 0;
}

.header {
  padding: 1rem;
  border-bottom: 1px solid black;
  max-width: 1200px;

  .header-nav {
    display: flex;
    justify-content: center;
    gap: 1rem;
    font-family: sans-serif;
    font-size: 1.2rem;
    padding: 0 3rem;

    .header-nav-link {
      text-decoration: none;
      color: var(--s-green);

      &:hover {
        transition: 0.3s;
        color: var(--s-black);
      }
    }
  }
}

.main {
  margin-top: 2rem;
}

</style>

<template>
  <transition
    appear
    appear-class="custom-appear-class"
    appear-to-class="custom-appear-to-class"
    (2.1.8+)
  >
    <div id="landing" class="d-flex flex-column justify-content-center align-items-center">
      <div id="title-container">
        <p class="title d-none d-lg-block">MEET THE WORLD</p>
        <p class="title d-block d-lg-none">LIVE</p>
      </div>
      <p v-if="isError" class="brand-info text-center p-1 w-100">{{errCountryNotFound}}</p>
      <search-city
        class="w-100 px-4"
        :searchLayout="{inputSize: 'col-12 col-sm-10 col-lg-6 mb-4 mb-sm-0 pr-0 pr-sm-2', buttonSize: 'col-12 col-sm-2 col-md-1'}"
        @search="redirect($event)"
      ></search-city>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      errCountryNotFound:
        "Sorry, we cannot find anything that matches your search term.",
      error: false
    };
  },
  methods: {
    redirect(country) {
      this.error = false;
      if (country) {
        this.$router.push({
          name: "bookablesByCountry",
          params: { country: country }
        });
      } else {
        this.error = true;
      }
    }
  },
  computed: {
    isError() {
      return this.error === true;
    }
  },
  created() {
    document.body.style.overflow = "hidden";
  },
  beforeDestroy() {
    document.body.style.overflow = "visible";
  }
};
</script>

<style scoped>
#landing {
  background: url("/images/landing/landing.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  width: 100%;
  height: 100vh;
}

.brand-info {
  background: var(--main-color);
  color: white;
  font-weight: 500 !important;
}

.custom-appear-class {
  opacity: 0;
}
.custom-appear-to-class {
  transition-duration: 1s;
  opacity: 1;
}
#title-container {
  width: 100%;
  text-align: center;
  background: #fffffff7;
  margin-bottom: 1rem;
}
.title {
  background: url("/images/landing/landing.jpg") NO-REPEAT;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 900 !important;
  font-size: 10vw;
  background-size: cover;
  line-height: 190px;
  padding: 0 20px;
}

::v-deep .search-container {
  margin-bottom: 35vh;
  width: 100%;
}
::v-deep .search-country-input {
  border: 6px solid rgba(0, 0, 0, 0.5);
  height: 60px;
  font-size: 1.2rem;
  color: rgb(77, 77, 77);
  background-color: rgba(255, 255, 255, 1);
}
::v-deep .search-country-input::placeholder {
  font-size: 1.2rem;
  font-weight: 300 !important;
  color: rgb(77, 77, 77);
}
::v-deep .btn {
  font-size: 1.1rem;
}
::v-deep .dropdown {
  width: calc(100% - (10px * 2));
  top: 55px;
  left: 6px;
}
::v-deep .dropdown li {
  background-color: rgba(255, 255, 255, 1);
  font-size: 1.2rem;
  font-weight: 300;
}

::v-deep .btn-go-container {
  width: 70px;
}

@media (max-width: 575px) {
  .title{
    font-size: 9rem;
    line-height: 150px;
  }
  ::v-deep .btn-go-container {
    width: 100%;
    height: 48px;
  }
  ::v-deep .dropdown li {
    background-color: white;
  }
  ::v-deep .dropdown {
    width: calc(100% - (6px * 2));
  }
}
@media (max-width: 767px) {
  ::v-deep .dropdown {
    bottom: 40px;
  }
}
</style>
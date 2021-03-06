<template>
  <div>
    <div class="row">
      <div class="col-md-8 pb-4">
        <div class="card">
          <div class="card-body">
            <div v-if="!loading">
              <h2>{{ bookable.title }}</h2>
              <hr />
              <article>{{ bookable.description }}</article>
              <div :style="{ backgroundImage: 'url(' + bookable.photo_url + ')' }" id="photo"></div>
            </div>
            <loading v-else></loading>
          </div>
        </div>
      </div>
      <div class="col-md-4 pb-4">
        <availability
          :bookable-id="this.$route.params.id"
          @availability="checkPrice($event)"
          class="mb-3"
        ></availability>

        <transition name="fade">
          <price-breakdown v-if="price" :price="price" class="mb-4"></price-breakdown>
        </transition>
        <transition name="fade">
          <button
            class="btn btn-main btn-block mb-2"
            v-if="price"
            @click="addToBasket"
            :disabled="inBasketAlready"
          >Add to basket</button>
        </transition>

        <router-link :to="{name: 'basket'}" class="btn btn-buy btn-block" v-if="inBasketAlready">
          <i class="fas fa-shopping-cart mr-1"></i>
          <span>Buy</span>
        </router-link>

        <div
          v-if="inBasketAlready"
          class="mt-2 text-muted warning"
        >If you would like to change dates, remove it from the basket first.</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-8">
        <review-list :bookable-id="this.$route.params.id"></review-list>
      </div>
    </div>
  </div>
</template>
<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";
import { mapState } from "vuex";

export default {
  components: {
    Availability,
    ReviewList,
    PriceBreakdown
  },
  data() {
    return {
      bookable: null,
      loading: false,
      price: null
    };
  },
  created() {
    this.loading = true;
    axios.get(`/api/bookables/${this.$route.params.id}`).then(result => {
      this.bookable = result.data;
      this.loading = false;
    });
  },
  computed: {
    ...mapState({
      lastSearch: "lastSearch"
    }),
    inBasketAlready() {
      if (null === this.bookable) {
        return false;
      }
      return this.$store.getters.inBasketAlready(this.bookable.id);
    }
  },
  methods: {
    async checkPrice(hasAvailability) {
      try {
        if (hasAvailability) {
          this.price = (
            await axios.get(
              `/api/bookables/${this.$route.params.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`
            )
          ).data;
        } else {
          this.price = null;
        }
      } catch (err) {
        this.price = null;
      }
    },
    addToBasket() {
      this.$store.dispatch("addToBasket", {
        bookable: this.bookable,
        price: this.price,
        dates: this.lastSearch
      });
    },
    removeFromBasket() {
      this.$store.dispatch("removeFromBasket", this.bookable.id);
    }
  }
};
</script>


<style scoped>
#photo {
  width: 100%;
  background-size: cover;
  margin-top: 1rem;
}
/* Trick to give the image resonsive height*/
#photo:after {
  content: "";
  display: block;
  padding-bottom: 60%;
}
</style>

<style scoped>
.warning {
  font-size: 0.7rem;
}
.btn-buy {
  background: #f08f0d;
  color: white;
}
.btn-buy:hover {
  background: #f09c2e;
  color: white;
}
</style> 
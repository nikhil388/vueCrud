<template>
    <div>
        <input type="hidden" v-model="rating" />
        <div class="rating">
            <span v-for="i in max" :key="i" :class="{ 'filled': i <= rating, 'empty': i > rating }" @click="submitRating(i)">
                ★
            </span>
        </div>
    </div>
</template>
  
<script>
export default {
    name: "Rating",
    props: {
        item: {
            type: Object,
            required: true,
        },
        max: {
            type: Number,
            default: 5,
        },
    },
    data() {
        return {
            rating: 0,
        };
    },
    methods: {
        submitRating(rating) {
            this.rating = rating;
            this.id = id;
            axios.post('rating/' + id, {
                student_id: this.student_id,
                rating: this.rating,
            })
                .then(response => {
                    this.getResults();
                }).catch(error => {
                    console.log(error);
                });

            // axios.post('/items/' + this.item.id + '/rate', {
            //   rating: rating,
            // }).then(response => {
            //   console.log(response.data.message);
            // }).catch(error => {
            //   console.error(error);
            // });

            this.$emit("input", rating);
        },
    },
};
</script>
  
<style scoped>
.rating {
    display: inline-block;
}

.filled {
    color: gold;
}

.empty {
    color: gray;
}
</style>
  
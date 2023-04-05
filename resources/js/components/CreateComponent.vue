<template>
    <h1>RatingPage</h1>
    <RatingComponent />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Create New Student</div>

                    <div class="card-body">
                        <div id="app">

                            <Form action="/upload" method="POST" id="app" @click="checkForm" novalidate="true"
                                enctype="multipart/form-data">
                                <input type="hidden" name="_token" :value="csrf">

                                <p v-if="errors.length">
                                    <b style="color:pink">Please correct the following error(s):</b>
                                <ul>
                                    <li v-for="(error, key) in errors" v-bind:key="error.id">{{ error }}</li>
                                </ul>
                                </p>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" v-model="name"
                                        v-validate="'alpha'" placeholder="Name" />
                                    <!-- <span>{{ errors.first('name') }}</span> -->
                                    <!-- <span style="color: red;">{{ errors.name }}</span> -->
                                    <span style="color: red;" v-if="errors.name"> {{ errors.name }} </span>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="text" v-model="email" name="email" class="form-control" :rules="validEmail"
                                        id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" />
                                    <span style="color: red;" v-if="errors.email"> {{ errors.email }} </span>

                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone No.</label>
                                    <input type="number" v-model="phone" name="phone" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Phone" />
                                    <span style="color: red;" v-if="errors.phone"> {{ errors.phone }} </span>


                                </div>
                                <div class="form-group">
                                    <label for="file">Select a file:</label>
                                    <input type="file" id="file" @change="onFileChange" name="file" v-on:change="onsubmit">
                                    <div id="preview">
                                        <img src="url" v-if="imageUrl" alt="Preview Image">
                                        <!-- <b><label for="file" style="margin-top: 15px;">Image</label></b>
                                    <input type="file" name="" class="form-control" v-on:change="onsubmit"> -->
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 15px;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </Form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="title is-4">
            </div>
            <b style="text-align: center;margin-top: 15px;">
                <p>All Student Rating</p>
            </b>
            <div>
                <b-form-rating v-model="value" variant="warning" readonly></b-form-rating>
                <p class="mt-2">Value: {{ value }}</p>
            </div>

            <div class="star-rating" style="text-align: center">
                <div>
                    <input type="hidden" v-model="rating" name="rating" />
                    <!-- <input type="hidden" v-model="rating" name="rating" value=""/> -->


                    <div class="rating">
                        <span aria-readonly="true" v-for="i in max" :key="i"
                            :class="{ 'filled': i <= rating, 'empty': i > rating }" @click="submitRating(i)">
                            ★
                        </span>
                    </div>
                    <div v-if="ratingSuccessMessage">
                        Thank you for rating!
                    </div>
                </div>
            </div>
            <div class="col-md-15">
                <div class="card">
                    <div class="card-header">All Student</div>

                    <div class="card-body">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">Select</th>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Image</th>

                                    <th>Action</th>
                                    <!-- <th>Status</th> -->
                                    <th scope="col">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(student, index) in students.data" :key="student">

                                    <td><input type="checkbox" name="" id=""></td>
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ student.name }}</td>

                                    <td>{{ student.email }}</td>
                                    <td>{{ student.phone }}</td>
                                    <!-- <td>{{ student.names }}</td> -->

                                    <td><img :src="`/storage/students/` + student.names" alt="image"
                                            style="height:80px;width:100px;object-fit:cover"></td>
                                    <td>
                                        <button type="button" @click="editStudent(student.id)"
                                            class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" style="margin-right: 16px">
                                            Edit
                                        </button>

                                        <button type="button" @click="deleteStudent(student.id)"
                                            class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </td>

                                    <td>
                                        <div class="star-ratings">
                                            <div>
                                                
                                                <input type="hidden" v-model="rating" />
                                                <div class="rating">
                                                    <span  v-for="i in max" :key="i"
                                                        :class="{ 'filled': i <= rating, 'empty': i > rating }"
                                                        @click.prevent="submitRating(i, student.id)" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                        ★
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <pagination :data="students" @pagination-change-page="getResults">

                        </pagination>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button typdeleteStudent="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="app">
                            <p v-if="errors.length">
                                <b>Please correct the following error(s):</b>
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                            </p>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" v-model="editname"
                                    data-vv-delay="100" v-validate="'required|alpha|min:20'" placeholder="Name">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" v-model="editemail" name="email" class="form-control"
                                    id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone No.</label>
                                <input type="number" v-model="editphone" phone="phone" class="form-control"
                                    id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Phone">
                            </div><br>
                            <div class="form-group">
                                <button type="submit" @click.prevent="updateStudent" class="btn btn-success "
                                    data-bs-dismiss="modal">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Button trigger modal -->
    

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div v-if="ratingSuccessMessage" style="color: Green;font-size: 3em;">
                        Thank you for rating!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Understood</button> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import { Form, Field } from 'vee-validate';

import laravelPagination from "laravel-vue-pagination";


// import { TailwindPagination } from 'laravel-vue-pagination';
// app.component('pagination', 'laravel-vue-pagination');


export default {
    name: "Rating",
    props: {
        
        max: {
            type: Number,
            default: 5,
        },
    },
    components: {
        'Pagination': laravelPagination,
        Form,
        Field,
    },

    data() {
        return {
            rating: 0,
            errors: [],
            id: '',
            students: {},
            phone: null,
            editname: "",
            editemail: "",
            editphone: "",
            // notifmsg: ''
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            image: "`/storage/students/` + student.names",
            url: null,
            value: 2,
            checkbox: false,
            ratingSuccessMessage: '',

        }
    },
    mounted() {
        this.getResults();
    },
    methods: {
        //     onFileChange(e) {
        //   const file = e.target.files[0];
        //   this.url = URL.createObjectURL(file);
        // },
        toggleCheckbox() {
            this.checkbox = !this.checkbox
            this.$emit('setCheckboxVal', this.checkbox)
        },
        onsubmit(e) {
            console.log(e.target.files[0])
            this.file = e.target.files[0];
            this.url = URL.createObjectURL(file);

        },
        formSubmit(e) {
            e.preventDefault();
            alert("hey")
            let existingObj = this;
            const config = {
                headers: {

                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('file', this.file);
            axios.post('/upload', data, config)
                .then(function (res) {
                    existingObj.success = res.data.success;
                })
                .catch(function (err) {
                    existingObj.output = err;
                });
        },
        checkForm: function (e) {
            this.errors = [];

            if (!this.name) {
                this.errors.name = "name is required."
            }
            if (!this.phone) {
                this.errors.phone = "Phone number is required.";
            }
            if (!this.email) {
                this.errors.email = 'email is required.';
            } else if (!this.validEmail(this.email)) {
                this.errors.email = 'Valid email required.';
            } email
            if (!this.errors.length) {
                return true;
            }

            e.preventDefault();

            // console.log('hello========>');
            console.log(this.errors);
        },
        validEmail: function (email) {
            // if(!email){
            //     return 'This field is required';
            // }
            var re = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            return re.test(email);
        },


        saveStudent() {
            axios.post('save_student', {
                name: this.name,
                email: this.email,
                phone: this.phone
            }).then(response => {
                this.name = "",
                    this.email = "",
                    this.phone = "",
                    this.getResults();
            });
        },
        getResults(page = 1) {
            axios.get('all_students?page=' + page)
                .then(response => {
                    console.log(response);
                    this.students = response.data;
                });
        },
        editStudent(id) {
            // alert(id);
            axios.get('edit_Student/' + id)
                .then(response => {
                    this.id = response.data.id,
                        this.editname = response.data.name,
                        this.editemail = response.data.email,
                        this.editphone = response.data.phone
                });
        },
        updateStudent() {
            // alert(this.id)
            axios.put('update_Student', {
                id: this.id,
                name: this.editname,
                email: this.editemail,
                phone: this.editphone,
            })
                .then(response => {
                    this.getResults();
                });
        },
        deleteStudent(id) {
            // 
            if (confirm("Do you really want to delete?")) {
                axios.delete('deleteStudent/' + id)
                    .then(response => {
                        this.getResults();
                    }).catch(error => {
                        console.log(error);
                    });


            }
        },

        submitRating(rating, id) {
            // if (confirm("Are you sure you want to success giving rateing.")) {
            this.rating = rating;
            this.student_id = id;
            this.ratingSuccessMessage = true;
            setTimeout(() => {
                this.ratingSuccessMessage = false;
            }, 20000);
            // alert(this.student_idrating)
            axios.post('submitRating/' + id, {
                id: this.student_id,
                rating: this.rating,
            })
                .then(response => {
                    this.getResults();
                }).catch(error => {
                    console.log(error);
                });
            // }
            // axios.post('/items/' + this.item.id + '/rate', {
            //   rating: rating,
            // }).then(response => {
            //   console.log(response.data.message);
            // }).catch(error => {
            //   console.error(error);
            // });
            // this.$emit("input", rating);
        },
        // submitRating(id) {
        //     axios.post('rating/' + id, {
        //         item_id: this.itemId,
        //         rating: this.rating,
        //     })
        //         .then(response => {
        //             this.getResults();
        //         }).catch(error => {
        //             console.log(error);
        //         });
        // }
    },
}

</script>
<style>
body {
    background-color: #e2e2e2;
}

.star-ratings {
    display: inline-block;
    color: gold;
    font-size: 0.5rem;
}

.star-rating {

    display: inline-block;
    color: gold;
    font-size: 3rem;
}

#app {
    padding: 20px;
}

#preview {
    display: flex;
    justify-content: center;
    align-items: center;
}

#preview img {
    max-width: 100%;
    max-height: 500px;
}

.btn-sm {
    min-width: 1.8em;
    margin-left: .1em;
    margin-right: .1em;
    cursor: pointer;
    margin-top: 5px;
    padding: 1px 1px;
    font-size: 15px;
    border-radius: 10px;
}

body {
    text-align: center;
    background: #51C3A0;
    padding: 50px
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked+.slider {
    background-color: #101010;
}

input:focus+.slider {
    box-shadow: 0 0 1px #101010;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

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
// Vue app for managing UI .
// Contains methods for getting all users, add new user, update and remove.
// Getting all users on start.

var app = new Vue({
  el: '#app',
  data: {
    errorMsg: '',
    successMsg: '',
    showAddModal: false,
    showEditModal: false,
    showDeleteModal: false,
    newUser: {name: "", email: "", phone: ""},
    currentUser: {},
    users: []
  },
  mounted: function(){
    this.getAllUsers();
  },
  methods: {
    getAllUsers() {
      axios.get("http://crud-vue-php.com/process.php?action=read")
          .then(function(response){

              if(response.data.error){
                app.errorMsg = response.data.message;
              }else{
                app.users = response.data.users;
              }
      });
    },

    addUser() {
      let formData = this.toFormData(app.newUser);
      axios.post("http://crud-vue-php.com/process.php?action=create", formData)
          .then(function(response){
            app.newUser = {name:"",email:"",phone:""};
            if(response.data.error){
              app.errorMsg = response.data.message;
            }else{
              app.successMsg = response.data.message;
              app.getAllUsers();
            }
          });
    },

    // Create a Form object from user object for sending to API endpoint.
    toFormData(obj){
      let fd = new FormData();
      for (const i in obj){
        fd.append(i,obj[i]);
      }
      return fd;
    },

    updateUser() {
      let formData = this.toFormData(app.currentUser);
      axios.post("http://crud-vue-php.com/process.php?action=update", formData)
          .then(function(response){
            app.currentUser = {};
            if(response.data.error){
              app.errorMsg = response.data.message;
            }else{
              app.successMsg = response.data.message;
              app.getAllUsers();
            }
          });
    },

    // Used for selecting user in order to edit or remove it.
    selectUser(user) {
      app.currentUser = user;
    },

    // Empty message bar.
    clearMsg(){
      app.errorMsg ="";
      app.successMsg = "";
    },

    deleteUser() {
      let formData = this.toFormData(app.currentUser);
      axios.post("http://crud-vue-php.com/process.php?action=delete", formData)
          .then(function(response){
            app.currentUser = {};
            if(response.data.error){
              app.errorMsg = response.data.message;
            }else{
              app.successMsg = response.data.message;
              app.getAllUsers();
            }
          });
    },
  }
});

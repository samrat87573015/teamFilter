
<template>
  <div>
    <h1 class="mb-30">Team Members</h1>

    <!-- Loading Spinner -->
    <div v-if="loading">
      <div class="loader">
        <span class="inner_loder"></span>
      </div>
    </div>


    <div class="filter_wrapper">
      <!-- Search Input -->
      <div>
        <label for="search">Search by Name:</label>
        <input class="search_input" type="text" v-model="searchTerm" @input="filterData" placeholder="Search team members..." />
      </div>

      <!-- Location Filter -->
      <div>
        <label for="location">Filter by Location:</label>
        <select class="select_input" v-model="selectedLocation" @change="filterData">
          <option value="">All Locations</option>
          <option v-for="location in locations" :key="location.id" :value="location.id">
            {{ location.name }}
          </option>
        </select>
      </div>

      <!-- Role Filter -->
      <div>
        <label for="role">Filter by Role:</label>
        <select class="select_input" v-model="selectedRole" @change="filterData">
          <option value="">All Roles</option>
          <option v-for="role in roles" :key="role.id" :value="role.id">
            {{ role.name }}
          </option>
        </select>
      </div>
    </div>



    <!-- Team Members List -->
    <div>
      <div class="team_member" v-for="member in filteredMembers" :key="member.id">
        <a :href="member.link">{{ member.title.rendered }}</a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      members: [],
      filteredMembers: [],
      locations: [],
      roles: [],
      selectedLocation: '',
      selectedRole: '',
      searchTerm: '',
      loading: true
    };
  },
  methods: {
    fetchData() {
      // Fetch team members
      this.loading = true;
      axios
          .get('http://tradmark.local/wp-json/wp/v2/team')
          .then((response) => {
            this.members = response.data;
            this.filteredMembers = response.data;
            this.loading = false;
          })
          .catch((error) => {
            console.error('Error fetching team members:', error);
          });

      // Fetch locations
      this.loading = true;
      axios
          .get('http://tradmark.local/wp-json/wp/v2/location')
          .then((response) => {
            this.locations = response.data;
            this.loading = false;
          })
          .catch((error) => {
            console.error('Error fetching locations:', error);
          });

      // Fetch roles
      this.loading = true;
      axios
          .get('http://tradmark.local/wp-json/wp/v2/role')
          .then((response) => {

            this.roles = response.data;
            this.loading = false;
          })
          .catch((error) => {
            console.error('Error fetching roles:', error);
          });
    },
    filterData() {
      this.filteredMembers = this.members.filter((member) => {
        // Filter by location
        const matchesLocation = this.selectedLocation
            ? member.location.includes(parseInt(this.selectedLocation))
            : true;

        // Filter by role
        const matchesRole = this.selectedRole
            ? member.role.includes(parseInt(this.selectedRole))
            : true;

        // Filter by search term
        const matchesSearchTerm = this.searchTerm
            ? member.title.rendered.toLowerCase().includes(this.searchTerm.toLowerCase())
            : true;
        return matchesLocation && matchesRole && matchesSearchTerm;
      });
    },
  },
  created() {
    this.fetchData();
  },
};
</script>



<style scoped>

.mb-30{
  margin-bottom: 30px;
}
.filter_wrapper{
  display: flex;
  flex-direction: row;
  align-items: center;
  margin-bottom: 30px;
  gap: 30px;
}
  .select_input{
    width: 100%;
    height: 50px;
    margin-bottom: 30px;
  }
  .search_input{
    width: 100%;
    height: 50px;
    margin-bottom: 30px;
  }
  .team_member{
    list-style: none;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
  }

</style>

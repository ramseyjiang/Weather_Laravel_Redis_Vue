<template>
	<div class="container mx-auto">
		<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 mb-4">
			<span>
				Restricted by free API, it only can get at most 5 daysforecast
			</span>
		</div>
		<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 mb-4">
			<span>Please input cityName:</span>
			<t-input
				v-model="searchCity"
				placeholder="auckland,nz / auckland"
				class="t-input t-input-size-sm t-input-status-default border block rounded p-1 text-sm bg-white"
			></t-input>
			<button
				type="button"
				variant="primary"
				@click="getCityWeather()"
				class="t-button t-button-size-sm border block rounded inline-flex items-center justify-center px-4 py-2 text-sm bg-white border-gray-400 hover:bg-gray-100 hover:border-gray-500"
			>
				Search
			</button>
		</div>
		<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 mb-4">
			<p v-show="!showTable">
				<span style="color:red">{{ errorMessage }}</span>
			</p>
			<p v-show="showTable">
				<span>City: {{ city }},</span>
				<span>Country: {{ country }}</span>
			</p>
			<t-table :headers="headers" :data="cityWeather"></t-table>
		</div>
	</div>
</template>
<script>
export default {
	data() {
		return {
			headers: ['Date', 'Weather', 'Temp', 'Wind', 'Clouds', 'Pressure'],
			cityWeather: [],
			searchCity: null,
			city: null,
			country: null,
			errorMessage: null,
			showTable: false,
		};
	},
	methods: {
		getCityWeather() {
			axios
				.get(baseUrl + '/api/weather/city/' + this.searchCity)
				.then(response => {
					if (response.data.status == 200) {
						this.showTable = true;
						this.city = response.data.data.city;
						this.country = response.data.data.country;
						this.cityWeather = response.data.data.list;
					} else {
						this.errorMessage = response.data.message;
						this.showTable = false;
						this.cityWeather = [];
					}
				})
				.catch(error => {
					console.log(error);
				});
		},
	},
};
</script>

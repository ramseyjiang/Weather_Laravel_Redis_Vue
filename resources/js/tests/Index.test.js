import { mount, createLocalVue } from '@vue/test-utils';
import Component from '../Index'; // name of your Vue component
import VueTailwind from 'vue-tailwind';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

describe('City weather test.', () => {
	let mock = new MockAdapter(axios);

	const localVue = createLocalVue();
	localVue.use(VueTailwind);

	let wrapper;
	// const getCityWeather = jest.fn();

	beforeEach(() => {
		wrapper = mount(Component, {
			localVue,
			methods: {
				getCityWeather,
			},
		});

		mock.onGet('/api/weather/city/auckland').reply(200, {
			status: 200,
			data: [
				{
					weather: 'Windy',
					date: '29/09/2019',
					temp: '27.86 to 27.86°С',
					wind: '3.85m/s',
					clouds: '9%',
					pressure: '1012.77hpa',
				},
				{
					weather: 'Sunny',
					date: '30/09/2019',
					temp: '28.17 to 28.17°С',
					wind: '5.88m/s',
					clouds: '0%',
					pressure: '1010.35hpa',
				},
				{
					weather: 'Clouds',
					date: '01/10/2019',
					temp: '26.53 to 26.53°С',
					wind: '6.43m/s',
					clouds: '67%',
					pressure: '1011.29hpa',
				},
				{
					weather: 'Clouds',
					date: '02/10/2019',
					temp: '27.27 to 27.27°С',
					wind: '4.74m/s',
					clouds: '86%',
					pressure: '1009.99hpa',
				},
			],
		});

		mock.onGet('/api/weather/city/sss').reply(200, {
			status: 404,
			message: 'city not found',
		});
	});

	afterEach(() => {
		wrapper.destroy();
	});

	it('Access city weather search page', () => {
		expect(wrapper.text()).toMatch(
			/Restricted by free API, it only can get at most 5 daysforecast/,
		);
		expect(wrapper.find('.t-button').text()).toBe('Search');
		expect(wrapper.text()).toMatch(/Weather/);
		expect(wrapper.text()).toMatch(/Temp/);
	});

	it('Click Search button, get city weather success', () => {
		wrapper.setData({
			searchCity: 'auckland',
			errorMessage: null,
			showTable: false,
		});

		wrapper
			.find('.t-button')
			.find('button')
			.trigger('click');

		expect(wrapper.text()).toMatch(/Country/);
		expect(wrapper.text()).toMatch(/Clouds/);
	});

	it('Click Search button, get city weather fail', () => {
		wrapper.setData({
			searchCity: 'sss',
			errorMessage: null,
			showTable: false,
		});

		wrapper
			.find('.t-button')
			.find('button')
			.trigger('click');
	});

	let getCityWeather = () => {
		axios
			.get('/api/weather/city/' + wrapper.vm.searchCity)
			.then(response => {
				if (response.data.status == 200) {
					wrapper.vm.showTable = true;
					wrapper.vm.city = response.data.data.city;
					wrapper.vm.country = response.data.data.country;
					wrapper.vm.cityWeather = response.data.data.list;
				} else {
					wrapper.vm.errorMessage = response.data.message;
					wrapper.vm.showTable = false;
					wrapper.vm.cityWeather = [];
					expect(wrapper.text()).toMatch(/city not found/);
				}
			})
			.catch(error => {
				console.log(error);
			});
	};
});

//从china-area-data/v4/data
const addressData = require('china-area-data/v4/data');
//引入lodash,lodash是一个实用工具库 ,提供了很多常用方法
import _ from 'lodash';

//注册一个名为select_district的组件
Vue.component('select-district', {
    // 定义组件的属性
    props: {
        // 用来初始化省市区的值.在编辑时会用到
        initValue: {
            type: Array,//格式数组
            dafault: () => ([]),//默认是个空数组
        }
    },
    //定义这个组件内的数据
    data() {
        return {
            provinces: addressData['86'],//省列表
            cities: {},//城市列表
            districts: {},//地区列表
            provinceId: '',//当前选中的省
            cityId: '',//当前选中的市
            districtId: '',//当前选中的区
        };
    },
    // 定义观察器,对应属性变更时会触发对应的观察期函数
    watch: {
        // 当选择的省发生改变时触发
        provinceId(newVal) {
            if (!newVal) {
                this.cities = {};
                this.cityId = '';
                return;
            }
            //将城市列表设为当前省份下的城市
            this.cities = addressData[newVal];
            //如果当前选中的城市b不在当前省下,则清空选中的城市
            if (!this.cities[this.cityId]) {
                this.cityId = '';
            }
        },
        //当选中的市发生改变时触发
        cityId(newVal) {
            if (!newVal) {
                this.districts = {};
                this.districtId = '';
                return;
            }
            // 将地区列表设为当前城市下的城市
            this.districts = addressData[newVal];
            // 如果当前选中的地区不在当前城市下,则清空选中的地区
            if (!this.districts[this.districtId]) {
                this.districtId = '';
            }
        },
        // 当选中的区发送改变时错发
        districtId() {
            // 触发一个名为change 的vue时间,事件的值就是当前选中的省市区名称,格式为数组
            this.$emit('change', [this.provinces[this.provinceId], this.cities[this.cityId], this.districts[this.districtId]]);
        },

    },
    //组件初始化时会调用方法
    created() {
        this.setFromValue(this.initValue);
    },
    methods: {
        setFromValue(value) {
            // 过滤掉控制
            value = _.filter(value);
            // 如果数组长度为0,则将省清空(由于我们定义了观察期,会联动触发将地区和城市清空)
            if (value.length === 0) {
                this.provinceId = '';
                return;
            }
            // 从当前省列表中找到与数组第一个元素同名的项的索引
            const cityId = _.findKey(addressData[provinceId], o => o === value[1]);
            // 没找到,请空城市的值
            if (!cityId) {
                this.cityId = '';
                return;
            }
            // 找到了,将当前城市设置对应的ID
            this.cityId = cityId;
            // 由于观察期的作用,这个时候地区列表已经变成了对应的地区列表
            // 从当前地区列表知道与数组第三个元素相同的项的索引
            const districtId = _.findKey(addressData[cityId], o => o === value[2]);
            //没找到,清空地区的值
            if (!districtId) {
                this.districtId = '';
                return;
            }
            //找到,将当前地区设置秤对应ID
            this.districtId = districtId;
        }
    }
});
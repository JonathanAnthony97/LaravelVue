<template>
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="cardTitle" class="h4"><i class="fas fa-hockey-puck"></i>&nbsp;&nbsp;Articles</span>
                    
                    <ul id="myNav" class="nav nav-pills nav-secondary">
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/recap"><i class="la flaticon-share"></i> &nbsp;Distribution</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/recap_stock">
                            <i class="flaticon-cloud"></i> &nbsp;Etat stock</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link myNav" to="/other">
                            <i class="flaticon-graph-2"></i> &nbsp;Histogramme</router-link>
                        </li>
                    </ul>
                    &nbsp;&nbsp;
                </div>
                <div class="card-body" id="myDiv">
                    <div class="row">
                    </div>
                    <div class="row">
                       <div class="col-md-6" style="margin-top: 22px;">
                           <apexchart height="400" type="bar" :options="options" :series="series"></apexchart>
                       </div>
                       <div class="col-md-6">
                           <fusioncharts
                                :type="type"
                                :width="width"
                                :height="height"
                                :dataFormat="dataFormat"
                                :dataSource="dataSource"
                                ></fusioncharts>
                       </div>
                   </div>
                </div>
            </div>
        </div> 
	</div>
        
    
</template>

<script>
import Vue from 'vue';
import VueFusionCharts from 'vue-fusioncharts';
import FusionCharts from 'fusioncharts';
import Column2D from 'fusioncharts/fusioncharts.charts';
import FusionTheme from 'fusioncharts/themes/fusioncharts.theme.fusion';

Vue.use(VueFusionCharts, FusionCharts, Column2D, FusionTheme);



    export default {
        data() {
            return{
                type: "scrollstackedbar2d",
                width: "100%",
                height: "450",
                dataFormat: "json",
                dataSource: {
                    chart: {
                        caption: "Bilan Stock",
                        captionFontSize: '11',
                        subcaption: "Quantité disponible",
                        //palettecolors: "518c71",
                        //showvalues: "1",
                        formatNumberScale: "0",
                        thousandSeparator: " ",
                        plottooltext: "<b>$seriesName</b><hr>$label: <b>$dataValue</b>",
                        //usePLotGradientColor: "1",
                       // pLotGradientColor: "#fffffff",
                        xaxisname: "Nom articles",
                        xaxisnameFontSize: '14',
                        numvisibleplot: "8",
                        theme: "fusion"
                    },
                    categories: [
                        {
                            category: ''
                        }
                    ],
                    dataset: []
                    },
                /////////////////////////////////////////////
                options: {
                    title: {
                        text: "Bilan Distribution",
                        align: 'center',
                        style: {
                            fontSize:  '11px',
                            fontWeight:  'bold',
                            fontFamily:  'sans-serif',
                            color:  '#575962'
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '35%', 
                        }
                    },
                    colors: ['#518c71'],
                    dataLabels: {
                        enabled: true
                    },
                    legend: {
                        show: true
                    },
                    xaxis: {
                        categories: '',
                        labels: {
                            style: {
                                fontSize: '13px'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Distribution',
                    data: []
                }]
            }
        },
        mounted() {
            this.$root.$emit('activeLink','recap');
            this.getbilan();
            this.getBilanStock();
        },
        methods:{
            getbilan(){
                axios.get('/getbilan').then((res) => {
                    this.options = {...this.options,...{
                        xaxis: {
                            categories: res.data.labels,
                            labels: {
                                style: {
                                    fontSize: '13px'
                                }
                            }
                        }
                    }}
                    this.series = [{
                        name: 'Distribution',
                        data: res.data.datasets
                    }];
                });
            },
            getBilanStock(){
                axios.get('/getbilanStock').then((res) => {
                    this.dataSource.categories = [
                        {
                            category: res.data.label
                        }
                    ];
                    for(let i = 0; i < res.data.dataset.length;i++){
                        this.dataSource.dataset.push(res.data.dataset[i]);
                    }
                    /*this.dataSource.dataset = [
                        {
                            seriesname: "Quantité en stock",
                            data: res.data.value
                        }
                    ];*/
                });
            }
        }
    }
</script>
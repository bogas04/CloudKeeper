function getAnalytics($targets) {
  views.showLoader();
  $.ajax({
    url: 'php/get_analytics.php',
    dataType : 'json',
    success: function(r) {
      if(!r.error) {
        var data = r.data;
        $targets.counts.html(views.renderTable([
              {analytic: 'Net Revenue', value: '₹ ' + (data.ownerData.netRevenue || 0)},
              {analytic: 'Net Profit', value: '₹ ' + (data.ownerData.netProfit || 0)},
              {analytic: 'Total Shops', value: data.counts.shopCount},
              {analytic: 'Total Items', value: data.counts.itemCount},
              {analytic: 'Total Invoices', value: data.counts.invoiceCount}
        ],[], null, 'table table-hover table-condensed'));
        $targets.mostSoldItems.html(views.renderTable(r.data.mostSold, ['item_id', 'shop_id'], null, 'table table-hover table-condensed'));
        $targets.leastSoldItems.html(views.renderTable(r.data.leastSold, ['item_id', 'shop_id'], null, 'table table-hover table-condensed'));
        $targets.mostProfitableItems.html(views.renderTable(r.data.mostProfitable, 
              ['item_id', 'frequency', 'average price'], null, 'table table-hover table-condensed'));
        $targets.leastProfitableItems.html(views.renderTable(r.data.leastProfitable, 
              ['item_id', 'frequency', 'average price'], null, 'table table-hover table-condensed'));
        $targets.revenueByShop.html(views.renderTable(r.data.shopData, [], null, 'table table-hover table-condensed'));

        var dataForChart = [];

        for(var i = 0; i < data.productWiseQuantity.length; i++) {
          var found = false;
          var currentItem = data.productWiseQuantity[i];
          var date = new Date(parseInt(currentItem.invoice_time_utc));
          var dataToAdd = [Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()), parseFloat(currentItem.quantity)];

          for(var j = 0; !found && j < dataForChart.length; j++) {
            if(dataForChart[j].item_id === currentItem.item_id) {
              dataForChart[j].data.push(dataToAdd);
              found = true;
            } 
          }
          if(!found) {
            dataForChart.push({
              item_id : currentItem.item_id,
              name : currentItem['item name'],
              data : [dataToAdd]
            });
          }
        }
        loadGraph(dataForChart);
        var dataForChart = [{ 
          name : 'Profit' , 
          data : [], 
          type : 'area', 
          color : '#5CB85C',
          fillOpacity : 1
        }, {
          name : 'Revenue', 
          data : [],
          type : 'area', 
          color : '#5BC0DE',
          fillOpacity : 0.3
        }];

        for(var i = 0; i < data.monthlyRevenueProfit.length; i++) {
          var currentItem = data.monthlyRevenueProfit[i];
          dataForChart[0].data.push([Date.UTC(currentItem.year, currentItem.month - 1 , 1),parseFloat(currentItem.profit)]);
          dataForChart[1].data.push([Date.UTC(currentItem.year, currentItem.month - 1, 1),parseFloat(currentItem.revenue)]);
        }

        loadAreaGraph(dataForChart);
        views.hideLoader();
      }
    } 
  });
}
function loadAreaGraph(data) {
  $('#areaChart').highcharts({
    chart: {
      type: 'area',
    },
    title: {
      text: 'Revenue/Profit (Monthly)'
    },
    xAxis: {
      type: 'datetime',
      dateTimeLabelFormats: {
        second: '%H:%M:%S',
        minute: '%H:%M',
        hour: '%H:%M',
        day: '%e. %b',
        week: '%e. %b',
        month: '%b', //month formatted as month only
        year: '%Y'
      },
    },
    yAxis: {
      title: {
        text: 'Indian Rupees ₹' 
      }
    },
    plotOptions: {
      area: {
        pointStart: 1,
        marker: {
          enabled: false,
          symbol: 'circle',
          radius: 2,
          states: {
            hover: {
              enabled: true
            }
          }
        }
      }
    },
    series: data
  });
}
function loadGraph(dataForChart) {
  console.log(dataForChart);
  $('#chart').highcharts({
    chart: {
      type: 'spline'
    },
    title: {
      text: 'Item Quantity vs Time'
    },
    xAxis: {
      type: 'datetime',
      title: {
        text: 'Date'
      },
      dateTimeLabelFormats: { // don't display the dummy year
        month: '%e. %b',
        year: '%y'
      },
    },
    yAxis: {
      title: {
        text: 'Quantity Sold'
      },
      min: 0
    },
    plotOptions: {
      spline: {
        marker: {
          enabled: true
        }
      }
    },
    series: dataForChart
  });
}
$(function() {
  //$(".dial").knob();
  getAnalytics({
    counts: $('.counts'),
    mostSoldItems: $('.most-sold-items'),
    leastSoldItems: $('.least-sold-items'),
    mostProfitableItems: $('.most-profitable-items'),
    leastProfitableItems: $('.least-profitable-items'),
    revenueByShop: $('.revenue-by-shop')
  });
});

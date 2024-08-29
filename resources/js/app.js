import './bootstrap';

import Chart from 'chart.js/auto';

$(document).ready(function() {
    const filterSelectVisitors = $('#filterSelect');
    const filterValueSelectVisitors = $('#filterValueSelect');
    const visitorsDateRange = $('#visitorsDateRange');

    const filterSelectUsers = $('#filterSelectUsers');
    const filterValueSelectUsers = $('#filterValueSelectUsers');
    const usersDateRange = $('#usersDateRange');

    const visitorsChartCanvas = $('#visitorsChart').get(0).getContext('2d');
    const usersChartCanvas = $('#usersChart').get(0).getContext('2d');

    let visitorsChart = new Chart(visitorsChartCanvas, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Visitors',
                data: [],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    let usersChart = new Chart(usersChartCanvas, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Users',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    function fetchChartData(chart, filterType, value, url, dateRangeElement) {
        $.getJSON(url, function(data) {
            chart.data.labels = data.labels;
            chart.data.datasets[0].data = data.data;
            chart.update();

            if (filterType === 'week') {
                const selectedYear = parseInt(value);
                const currentWeek = getWeekNumber(new Date());
                const startDate = getDateOfISOWeek(currentWeek, selectedYear);
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 6);
                dateRangeElement.text(`${formatDate(startDate)} - ${formatDate(endDate)}`).show();
            } else {
                dateRangeElement.text('').hide();
            }

            if (filterType === 'year') {
                dateRangeElement.hide();

                const currentYear = new Date().getFullYear();
                if (parseInt(value) !== currentYear) {
                    filterType = 'year';
                    fetchChartData(chart, filterType, 'this_year', url, dateRangeElement);
                }
            }
        }).fail(function(error) {
            console.error('Error fetching data:', error);
        });
    }

    function populateFilterValueOptions(filterType, selectElement) {
        selectElement.empty();
        if (filterType === 'week') {
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i >= 2000; i--) {
                selectElement.append(`<option value="${i}">${i}</option>`);
            }
            selectElement.val(currentYear);
        } else if (filterType === 'year') {
            selectElement.append(`<option value="this_year">This Year</option>`);
        }
    }

    function getWeekNumber(d) {
        const date = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        date.setHours(0, 0, 0, 0);
        date.setDate(date.getDate() + 4 - (date.getDay() || 7));
        const yearStart = new Date(date.getFullYear(), 0, 1);
        const weekNo = Math.ceil((((date - yearStart) / 86400000) + 1) / 7);
        return weekNo;
    }

    function getDateOfISOWeek(week, year) {
        const simple = new Date(year, 0, 1 + (week - 1) * 7);
        const dayOfWeek = simple.getDay();
        const ISOweekStart = simple;
        if (dayOfWeek <= 4) {
            ISOweekStart.setDate(simple.getDate() - simple.getDay() + 1);
        } else {
            ISOweekStart.setDate(simple.getDate() + 8 - simple.getDay());
        }
        return ISOweekStart;
    }

    function formatDate(date) {
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    filterSelectVisitors.on('change', function() {
        const filterType = $(this).val();
        populateFilterValueOptions(filterType, filterValueSelectVisitors);

        const value = filterValueSelectVisitors.val();
        fetchChartData(visitorsChart, filterType, value, `/visitors-chart-data?filter_type=${filterType}&value=${value}`, visitorsDateRange);
    });

    filterSelectUsers.on('change', function() {
        const filterType = $(this).val();
        populateFilterValueOptions(filterType, filterValueSelectUsers);

        const value = filterValueSelectUsers.val();
        fetchChartData(usersChart, filterType, value, `/users-chart-data?filter_type=${filterType}&value=${value}`, usersDateRange);
    });

    filterValueSelectVisitors.on('change', function() {
        const filterType = filterSelectVisitors.val();
        const value = $(this).val();
        fetchChartData(visitorsChart, filterType, value, `/visitors-chart-data?filter_type=${filterType}&value=${value}`, visitorsDateRange);
    });

    filterValueSelectUsers.on('change', function() {
        const filterType = filterSelectUsers.val();
        const value = $(this).val();
        fetchChartData(usersChart, filterType, value, `/users-chart-data?filter_type=${filterType}&value=${value}`, usersDateRange);
    });

    // Initial load for both charts
    populateFilterValueOptions(filterSelectVisitors.val(), filterValueSelectVisitors);
    fetchChartData(visitorsChart, filterSelectVisitors.val(), filterValueSelectVisitors.val(), `/visitors-chart-data?filter_type=${filterSelectVisitors.val()}&value=${filterValueSelectVisitors.val()}`, visitorsDateRange);

    populateFilterValueOptions(filterSelectUsers.val(), filterValueSelectUsers);
    fetchChartData(usersChart, filterSelectUsers.val(), filterValueSelectUsers.val(), `/users-chart-data?filter_type=${filterSelectUsers.val()}&value=${filterValueSelectUsers.val()}`, usersDateRange);

});
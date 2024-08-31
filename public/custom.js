$(document).ready(function () {
    const currentPath = window.location.pathname;

    if (currentPath.includes("/login")) {
        $("#loginOffcanvas").offcanvas("show");
    } else if (currentPath.includes("/register")) {
        $("#registerOffcanvas").offcanvas("show");
    }

    $("#chatBubbleContainer .btn-close").click(function () {
        $("#chatBubbleContainer").hide();
    });

    const daysOfWeek = [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
    ];

    const visitors_chart_options = {
        series: [
            {
                name: "This Week",
                data: [],
            },
            {
                name: "Last Week",
                data: [],
            },
        ],
        chart: {
            height: 200,
            type: "line",
            toolbar: {
                show: false,
            },
        },
        colors: ["#0d6efd", "#adb5bd"],
        stroke: {
            curve: "smooth",
        },
        grid: {
            borderColor: "#e7e7e7",
            row: {
                colors: ["#f3f3f3", "transparent"],
                opacity: 0.5,
            },
        },
        markers: {
            size: 1,
        },
        xaxis: {
            categories: daysOfWeek,
        },
        legend: {
            show: true,
        },
    };

    const chartElement = document.querySelector("#visitors-chart");
    if (chartElement) {
        const visitors_chart = new ApexCharts(
            chartElement,
            visitors_chart_options
        );
        visitors_chart.render();

        $.ajax({
            url: "/chart-data",
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.thisWeek && data.lastWeek) {
                    const thisWeekData = daysOfWeek.map((day) => {
                        const entry = data.thisWeek.find(
                            (item) => item.day === day
                        );
                        return entry ? entry.count : 0;
                    });

                    const lastWeekData = daysOfWeek.map((day) => {
                        const entry = data.lastWeek.find(
                            (item) => item.day === day
                        );
                        return entry ? entry.count : 0;
                    });

                    visitors_chart.updateOptions({
                        series: [
                            {
                                name: "This Week",
                                data: thisWeekData,
                            },
                            {
                                name: "Last Week",
                                data: lastWeekData,
                            },
                        ],
                    });

                    $(".total-visitors").text(data.totalVisitorsThisWeek);
                    $(".percentage-increase").html(
                        `<i class="bi bi-arrow-up"></i> ${data.percentageIncrease}%`
                    );
                } else {
                    console.error("Invalid data format:", data);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    } else {
        console.error("Chart element not found.");
    }

    const consentBanner = $("#cookie-consent-banner");
    const acceptButton = $("#accept-cookies");
    const rejectButton = $("#reject-cookies");

    // Check if cookie consent is already given or rejected
    if (!getCookie("cookie_consent")) {
        consentBanner.removeClass("d-none");
    }

    acceptButton.on("click", function () {
        setCookie("cookie_consent", "accepted", 30);
        consentBanner.addClass("d-none");
    });

    rejectButton.on("click", function () {
        setCookie("cookie_consent", "rejected", 30);
        consentBanner.addClass("d-none");
    });

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    $(document).on("click", ".user-item", function () {
        $(".user-item").removeClass("selected");

        $(this).addClass("selected");
    });

    function showToast(message, bgColor = "bg-success") {
        var toastElement = $("#customToast");

        $("#toast-message").text(message);
        toastElement
            .removeClass("bg-success bg-danger bg-warning")
            .addClass(bgColor);

        var toast = new bootstrap.Toast(toastElement[0]);
        toast.show();
    }
});

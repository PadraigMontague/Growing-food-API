$(document).ready(function () {
    $('#register').click(function (e) {
        e.preventDefault();
        var arr = {
            "username": $("#username").val(),
            "email": $("#email").val()
        };
        $.ajax({
            type: 'POST',
            url: 'http://localhost/authentication/auth/register/',
            data: JSON.stringify(arr),
            contentType: 'application/json',
            dataType: "json",
            success: function (response) {
                if (response === "Username Already Exists") {
                    document.querySelector('.message').innerHTML = "Username Already Exists";
                } else {
                    document.querySelector('.token').innerHTML = "<p class='jwt'>" + response[0].jwt + "</p>";
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
});

$(document).ready(function () {
    $('#login').click(function (e) {
        e.preventDefault();
        var details = {
            "username": $("#loginUsername").val(),
            "email": $("#loginEmail").val()
        };
        $.ajax({
            type: 'POST',
            url: 'http://localhost/authentication/auth/login/',
            data: JSON.stringify(details),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                if (response === 'Revoked') {
                    console.log(response)
                    document.querySelector('.loginMessage').innerHTML = "Your Token Has Been Revoked";
                } else if (response[0].token === undefined) {
                    document.querySelector('.loginMessage').innerHTML = "Unauthorised";

                } else {
                    localStorage.setItem('username', $("#loginUsername").val());
                    localStorage.setItem('token', response[0].token);
                    window.location = "http://localhost/frontend/search.html";
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
});

/** 
 * SEARCH BY NAME
 */

$(document).ready(function () {
    $('#search').click(function (e) {
        e.preventDefault();

        var details = {
            "token": localStorage.getItem('token'),
            "username": localStorage.getItem('username'),
            "name": $('#inputName').val()
        };

        if ($("#vegName").val() === 'Vegetables') {
            var url = 'http://localhost/principle/vegetables/fetchByName/';
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify(details),
                contentType: 'application/json',
                dataType: 'json',
                success: function (veg) {
                    if (veg[0].name != undefined) {
                        let htmlOutput = '<div>';
                        veg.forEach((veg) => {
                            htmlOutput += '<div class="tab">' +
                                '<p>' + 'Vegetable Name: ' + veg.name + '</p>' +
                                '<p>' + 'Type: ' + veg.type + '</p>' +
                                '<p>' + 'Planting Month: ' + veg.sowMonth + '</p>' +
                                '<p>' + 'Harvest Month: ' + veg.harvestMonth + '</p>' +
                                '<p>' + 'Minimum Temperature: ' + veg.minTemp + '</p>' +
                                '<p>' + 'Soil Type: ' + veg.soilType + '</p>' +
                                '</div>';
                        });

                        htmlOutput += '</div>';
                        document.getElementById("data").innerHTML = htmlOutput;
                    } else {
                        document.querySelector("#data").innerHTML = '<p class="noDATA">Sorry there is no data available</p>';
                    }
                },
                error() {
                    document.querySelector("#data").innerHTML = '<p class="noDATA">Sorry there is no data available</p>';
                }
            });
        } else if ($("#vegName").val() === 'Fruit') {
            var url = 'http://localhost/principle/fruit/fetchByName/';
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify(details),
                contentType: 'application/json',
                dataType: 'json',
                success: function (fruit) {
                    if (fruit[0].name != undefined) {
                        let htmlOutput = '<div>';
                        fruit.forEach((response) => {
                            htmlOutput += '<div class="tab">' +
                                '<p>' + 'Fruit Name: ' + fruit[0].name + '</p>' +
                                '<p>' + 'Type: ' + fruit[0].type + '</p>' +
                                '<p>' + 'Planting Month: ' + fruit[0].plantingMonth + '</p>' +
                                '<p>' + 'Harvest Month: ' + fruit[0].harvestMonth + '</p>' +
                                '<p>' + 'Soil Type: ' + fruit[0].soilType + '</p>' +
                                '</div>';
                        });
                        htmlOutput += '</div>';
                        document.getElementById("data").innerHTML = htmlOutput;
                    } else {
                        document.querySelector("#data").innerHTML = '<p class="noDATA">Sorry there is no data available</p>';
                    }
                },
                error() {
                    document.querySelector("#data").innerHTML = '<p class="noDATA">Sorry there is no data available</p>';
                }
            });
        } else {
            document.querySelector("#data").innerHTML = '<p class="noDATA">Please select the type of plant you want to grow.</p>';
        }

    });
});

/** 
 * SEARCH BY PLANTING MONTH
 */


$(document).ready(function () {
    $('#searchByMonth').click(function (e) {
        e.preventDefault();

        var details = {
            "token": localStorage.getItem('token'),
            "username": localStorage.getItem('username'),
            "sowMonth": $("#monthName").val()
        };

        if ($("#vegNameMonth").val() === 'Vegetables') {
            var url = 'http://localhost/principle/vegetables/searchSowMonth/';
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify(details),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    let htmlOutput = '<div>';
                    response.forEach((response) => {
                        htmlOutput += '<div class="tab">' +
                            '<p>' + 'Vegetable Name: ' + response.name + '</p>' +
                            '<p>' + 'Type: ' + response.type + '</p>' +
                            '<p>' + 'Planting Month: ' + response.sowMonth + '</p>' +
                            '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                            '<p>' + 'Minimum Temperature: ' + response.minTemp + '</p>' +
                            '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                            '</div>';
                    });

                    htmlOutput += '</div>';
                    document.getElementById("data").innerHTML = htmlOutput;
                },
                error: function (e) {
                    if (e.responseJSON.success.length == 0) {
                        console.log('No Data Available');
                        document.getElementById("data").innerHTML = '<p class="noDATA">Sorry There Is No Data Available</p>';
                    }
                }
            });
        } else {
            var url = 'http://localhost/principle/fruit/plantingMonth/';
            var details = {
                "token": localStorage.getItem('token'),
                "username": localStorage.getItem('username'),
                "plantingMonth": $("#monthName").val()
            };
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify(details),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    if (response[0].name != undefined) {
                        let htmlOutput = '<div>';
                        response.forEach((response) => {
                            htmlOutput += '<div class="tab">' +
                                '<p>' + 'Fruit Name: ' + response.name + '</p>' +
                                '<p>' + 'Type: ' + response.type + '</p>' +
                                '<p>' + 'Planting Month: ' + response.plantingMonth + '</p>' +
                                '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                                '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                                '</div>';
                        });
                        htmlOutput += '</div>';
                        document.getElementById("data").innerHTML = htmlOutput;
                    } else {
                        document.querySelector("#data").innerHTML = '<p class="noDATA">Sorry there is not data available</p>';
                    }
                },
                error() {
                    document.querySelector("#data").innerHTML = '<p class="noDATA">Sorry there is no data available</p>';
                }
            });
        }
    });
});

$(document).ready(function () {
    $('#calculate').click(function (e) {
        e.preventDefault();

        var details = {
            "token": localStorage.getItem('token'),
            "username": localStorage.getItem('username'),
            "squareFeet": $("#squareFeet").val(),
            "spacing": $("#spacing").val(),
        };
        var url = 'http://localhost/principle/vegetables/calculate/';
        $.ajax({
            type: 'POST',
            url: url,
            data: JSON.stringify(details),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                let htmlOutput = '<div>';
                response.forEach((response) => {
                    htmlOutput += '<div class="tab">' +
                        '<p class="numberOfPlants">' + 'Number of plants: ' + response.NumberOfPlants + '</p>' +
                        '</div>';
                });

                htmlOutput += '</div>';
                document.getElementById("data").innerHTML = htmlOutput;
            }
        });
    });
});

$(document).ready(function () {
    $('#getWeather').click(function (e) {
        e.preventDefault();

        var location = {
            "placename": $("#placename").val(),
        };
        var url = 'http://localhost/principle/vegetables/weather/';
        $.ajax({
            type: 'POST',
            url: url,
            data: JSON.stringify(location),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                response.forEach((response) => {

                    htmlOutput = '<div class="tab">' +
                        '<p>' + 'Current temperature:  ' + response.temperature + ' degrees' + '</p>' +
                        '<p>' + 'Planting conditions:  ' + response.plantingConditions + '</p>' +
                        '<p>' + 'Growing tips: ' + response.tips + '</p>';

                    document.getElementById("data").innerHTML = htmlOutput;
                });
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
});

let displaySearchByName = () => {
    document.querySelector('.searchBar').style.display = 'block';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.calculator').style.display = 'none';
    document.querySelector('.searchByWeather').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
};

let displaySearchByMonth = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.calculator').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'block';
    document.querySelector('.searchByWeather').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
};

let displayCalculator = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.calculator').style.display = 'block';
    document.querySelector('.searchByWeather').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
}

let displayWeather = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.calculator').style.display = 'none';
    document.querySelector('.searchByWeather').style.display = 'block';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = 'cadetblue';
    document.querySelector('#data').innerHTML = '';
}

$(document).ready(function () {
    $('#searchDevMode').click(function (e) {
        e.preventDefault();

        var details = {
            "token": localStorage.getItem('token'),
            "username": localStorage.getItem('username'),
            "name": $("#plantType").val()
        };

        if ($("#vegName").val() === 'Vegetables') {
            document.querySelector('#data').innerHTML = '';
            var url = 'http://localhost/principle/vegetables/fetchByName/';
            if ($("#dataType").val() === 'JSON') {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(details),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        document.querySelector("#data").innerHTML = '';
                        let htmlOutput = '<div>';
                        response.forEach((response) => {
                            htmlOutput += '<div class="tab">' +
                                '<p>' + 'Vegetable Name: ' + response.name + '</p>' +
                                '<p>' + 'Type: ' + response.type + '</p>' +
                                '<p>' + 'Planting Month: ' + response.sowMonth + '</p>' +
                                '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                                '<p>' + 'Minimum Temperature: ' + response.minTemp + '</p>' +
                                '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                                '</div>';
                        });

                        htmlOutput += '</div>';
                        document.getElementById("data").innerHTML = htmlOutput;
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(details),
                    contentType: 'application/json',
                    dataType: 'xml',
                    success: function (response) {
                        $(response).find('vegetable').each(function () {
                            $("#data").append("<div class='tab'><p> Name: " + $(this).find("name").text() + "</p>" +
                                "<p> Type: " + $(this).find("type").text() + "<p>" +
                                "<p> Sowing Month: " + $(this).find("sowMonth").text() + "<p>" +
                                "<p> Minimum Temperature: " + $(this).find("minTemp").text() +
                                "<p>" + "<p> Soil Type: " + $(this).find("soilType").text() +
                                "<p>" + "</div>"
                            );
                        });
                    },
                });
            }
        } else if ($("#vegName").val() === 'Fruit') {
            var url = 'http://localhost/principle/fruit/fetchByName/';
            document.querySelector('#data').innerHTML = '';
            if ($("#dataType").val() === 'JSON') {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(details),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        document.querySelector("#data").innerHTML = '';
                        let htmlOutput = '<div>';
                        response.forEach((response) => {
                            htmlOutput += '<div class="tab">' +
                                '<p>' + 'Fruit Name: ' + response.name + '</p>' +
                                '<p>' + 'Type: ' + response.type + '</p>' +
                                '<p>' + 'Planting Month: ' + response.plantingMonth + '</p>' +
                                '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                                '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                                '</div>';
                        });

                        htmlOutput += '</div>';
                        document.getElementById("data").innerHTML = htmlOutput;
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(details),
                    contentType: 'application/json',
                    dataType: 'xml',
                    success: function (response) {
                        $(response).find('fruit').each(function () {
                            $("#data").append("<div class='tab'><p> Name: " + $(this).find("name").text() + "</p>" +
                                "<p> Type: " + $(this).find("type").text() + "<p>" +
                                "<p> Sowing Month: " + $(this).find("plantingMonth").text() + "<p>" +
                                "<p>" + "<p> Soil Type: " + $(this).find("soilType").text() +
                                "<p>" + "</div>"
                            );
                        });
                    },
                });
            }
        }

    });
});

$(document).ready(function () {
    $('#searchByMonthDevMode').click(function (e) {
        e.preventDefault();

        var details = {
            "token": localStorage.getItem('token'),
            "username": localStorage.getItem('username'),
            "sowMonth": $("#monthName").val()
        };

        if ($("#vegNameMonth").val() === 'Vegetables') {
            var url = 'http://localhost/principle/vegetables/searchSowMonth/';
            document.querySelector('#data').innerHTML = '';
            if ($("#dataType").val() === 'JSON') {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(details),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        document.querySelector("#data").innerHTML = '';
                        let htmlOutput = '<div>';
                        response.forEach((response) => {
                            htmlOutput += '<div class="tab">' +
                                '<p>' + 'Vegetable Name: ' + response.name + '</p>' +
                                '<p>' + 'Type: ' + response.type + '</p>' +
                                '<p>' + 'Planting Month: ' + response.sowMonth + '</p>' +
                                '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                                '<p>' + 'Minimum Temperature: ' + response.minTemp + '</p>' +
                                '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                                '</div>';
                        });

                        htmlOutput += '</div>';
                        document.getElementById("data").innerHTML = htmlOutput;
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(details),
                    contentType: 'application/json',
                    dataType: 'xml',
                    success: function (response) {
                        $(response).find('vegetable').each(function () {
                            $("#data").append("<div class='tab'><p> Name: " + $(this).find("name").text() + "</p>" +
                                "<p> Type: " + $(this).find("type").text() + "<p>" +
                                "<p> Sowing Month: " + $(this).find("sowMonth").text() + "<p>" +
                                "<p> Minimum Temperature: " + $(this).find("minTemp").text() +
                                "<p>" + "<p> Soil Type: " + $(this).find("soilType").text() +
                                "<p>" + "</div>"
                            );
                        });
                    },
                });
            }
        } else if ($("#vegNameMonth").val() === 'Fruit') {
            var url = 'http://localhost/principle/fruit/plantingMonth/';
            document.querySelector('#data').innerHTML = '';
            var detailsTwo = {
                "token": localStorage.getItem('token'),
                "username": localStorage.getItem('username'),
                "plantingMonth": $("#monthName").val()
            };
            if ($("#dataType").val() === 'JSON') {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(detailsTwo),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        document.querySelector("#data").innerHTML = '';
                        let htmlOutput = '<div>';
                        response.forEach((response) => {
                            htmlOutput += '<div class="tab">' +
                                '<p>' + 'Fruit Name: ' + response.name + '</p>' +
                                '<p>' + 'Type: ' + response.type + '</p>' +
                                '<p>' + 'Planting Month: ' + response.plantingMonth + '</p>' +
                                '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                                '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                                '</div>';
                        });

                        htmlOutput += '</div>';
                        document.getElementById("data").innerHTML = htmlOutput;
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(detailsTwo),
                    contentType: 'application/json',
                    dataType: 'xml',
                    success: function (response) {
                        $(response).find('fruit').each(function () {
                            $("#data").append("<div class='tab'><p> Name: " + $(this).find("name").text() + "</p>" +
                                "<p> Type: " + $(this).find("type").text() + "<p>" +
                                "<p> Sowing Month: " + $(this).find("plantingMonth").text() + "<p>" +
                                "<p>" + "<p> Soil Type: " + $(this).find("soilType").text() +
                                "<p>" + "</div>"
                            );
                        });
                    },
                });
            }
        }

    });
});


/**
 * DEVELOPER ONLY FUNCTIONALITY
 */

$(document).ready(function () {
    $('#createV').click(function (e) {
        e.preventDefault();
        var create = {
            "token": localStorage.getItem('token'),
            "username": localStorage.getItem('username'),
            "name": $('#vegname').val(),
            "type": $('#type').val(),
            "sowMonth": $('#sowMonth').val(),
            "harvestMonth": $('#harvestMonth').val(),
            "minTemp": $('#minTemp').val(),
            "soilType": $('#soilType').val()
        };
        $.ajax({
            type: 'POST',
            url: 'http://localhost/principle/vegetables/create/',
            data: JSON.stringify(create),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                document.querySelector('.response').innerHTML = 'Successfuly Created';
            },
            error: function () {
                document.querySelector('.response').innerHTML = 'Unsuccessful';
            }
        });
    });
});

$(document).ready(function () {
    $('#createF').click(function (e) {
        e.preventDefault();
        var create = {
            "token": localStorage.getItem('token'),
            "username": localStorage.getItem('username'),
            "name": $('#fruitname').val(),
            "type": $('#fruitType').val(),
            "plantingMonth": $('#plantingMonth').val(),
            "harvestMonth": $('#harvestMonthFruit').val(),
            "soilType": $('#soilTypeFruit').val()
        };
        $.ajax({
            type: 'POST',
            url: 'http://localhost/principle/fruit/create/',
            data: JSON.stringify(create),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response === 'Required fields not filled') {
                    document.querySelector('.responseTwo').innerHTML = 'Required fields not filled';
                } else {
                    document.querySelector('.responseTwo').innerHTML = 'Successfuly Created';
                }
            },
            error: function () {
                document.querySelector('.responseTwo').innerHTML = 'Unsuccessful';
            }
        });
    });
});

// DEVELOPER MODE 


let displaySearchByNameDev = () => {
    document.querySelector('.searchBar').style.display = 'block';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.createVeg').style.display = 'none';
    document.querySelector('.createFruit').style.display = 'none';
    document.querySelector('.displayAll').style.display = 'none';
    document.querySelector('.displayAllFruit').style.display = 'none';
    document.querySelector('.updateVeg').style.display = 'none';
    document.querySelector('.updateFruit').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('.switchFive').style.backgroundColor = '#fff';
    document.querySelector('.switchSix').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
    document.querySelector('.response').innerHTML = '';
};

let displaySearchByMonthDev = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'block';
    document.querySelector('.createVeg').style.display = 'none';
    document.querySelector('.createFruit').style.display = 'none';
    document.querySelector('.displayAll').style.display = 'none';
    document.querySelector('.displayAllFruit').style.display = 'none';
    document.querySelector('.updateVeg').style.display = 'none';
    document.querySelector('.updateFruit').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('.switchFive').style.backgroundColor = '#fff';
    document.querySelector('.switchSix').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
    document.querySelector('.response').innerHTML = '';
};

let createVegDev = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.createVeg').style.display = 'block';
    document.querySelector('.createFruit').style.display = 'none';
    document.querySelector('.displayAll').style.display = 'none';
    document.querySelector('.displayAllFruit').style.display = 'none';
    document.querySelector('.updateVeg').style.display = 'none';
    document.querySelector('.updateFruit').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('.switchFive').style.backgroundColor = '#fff';
    document.querySelector('.switchSix').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
}

let createFruitDev = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.createVeg').style.display = 'none';
    document.querySelector('.createFruit').style.display = 'block';
    document.querySelector('.displayAll').style.display = 'none';
    document.querySelector('.displayAllFruit').style.display = 'none';
    document.querySelector('.updateVeg').style.display = 'none';
    document.querySelector('.updateFruit').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchFive').style.backgroundColor = '#fff';
    document.querySelector('.switchSix').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
}

let displayAllDev = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.createVeg').style.display = 'none';
    document.querySelector('.createFruit').style.display = 'none';
    document.querySelector('.displayAll').style.display = 'block';
    document.querySelector('.displayAllFruit').style.display = 'block';
    document.querySelector('.updateVeg').style.display = 'none';
    document.querySelector('.updateFruit').style.display = 'none';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('.switchFive').style.backgroundColor = 'cadetblue';
    document.querySelector('.switchSix').style.backgroundColor = '#fff';
    document.querySelector('#data').innerHTML = '';
}

let displayToUpdateDev = () => {
    document.querySelector('.searchBar').style.display = 'none';
    document.querySelector('.searchByMonth').style.display = 'none';
    document.querySelector('.createVeg').style.display = 'none';
    document.querySelector('.createFruit').style.display = 'none';
    document.querySelector('.displayAll').style.display = 'none';
    document.querySelector('.displayAllFruit').style.display = 'none';
    document.querySelector('.updateVeg').style.display = 'block';
    document.querySelector('.updateFruit').style.display = 'block';
    document.querySelector('.switchTwo').style.backgroundColor = '#fff';
    document.querySelector('.switchOne').style.backgroundColor = '#fff';
    document.querySelector('.switchThree').style.backgroundColor = '#fff';
    document.querySelector('.switchFour').style.backgroundColor = '#fff';
    document.querySelector('.switchFive').style.backgroundColor = '#fff';
    document.querySelector('.switchSix').style.backgroundColor = 'cadetblue';
    document.querySelector('#data').innerHTML = '';
}

function logout() {
    localStorage.clear();
    window.location = "http://localhost/frontend/";
}

/** 
 * FETCH ALL
 */


function displayAll() {
    var details = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username')
    };

    var url = 'http://localhost/principle/vegetables/fetchAll/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(details),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            let htmlOutput = '<div class="fetchAllWrapper">';
            response.forEach((response) => {
                htmlOutput += '<div class="fetchAllTab">' +
                    '<p>' + 'Vegetable Name: ' + response.name + '</p>' +
                    '<p>' + 'Type: ' + response.type + '</p>' +
                    '<p>' + 'Planting Month: ' + response.sowMonth + '</p>' +
                    '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                    '<p>' + 'Minimum Temperature: ' + response.minTemp + '</p>' +
                    '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                    '<button class="deleteBtn" onclick="deleteVeg(' + response.id + ')">Delete</button>' +
                    '</div>';
            });

            htmlOutput += '</div>';
            document.getElementById("data").innerHTML = htmlOutput;
        }
    });
}

let deleteVeg = (id) => {
    var details = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username'),
        "id": id
    };

    var url = 'http://localhost/principle/vegetables/delete/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(details),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {

        },
        error: function (e) {
            console.log(e);
        }
    });
}

function displayAllFruit() {
    var details = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username')
    };

    var url = 'http://localhost/principle/fruit/fetchAll/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(details),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            let htmlOutput = '<div class="fetchAllWrapper">';
            response.forEach((response) => {
                htmlOutput += '<div class="fetchAllTab">' +
                    '<p>' + 'Vegetable Name: ' + response.name + '</p>' +
                    '<p>' + 'Type: ' + response.type + '</p>' +
                    '<p>' + 'Planting Month: ' + response.plantingMonth + '</p>' +
                    '<p>' + 'Harvest Month: ' + response.harvestMonth + '</p>' +
                    '<p>' + 'Soil Type: ' + response.soilType + '</p>' +
                    '<button class="deleteBtn" onclick="deleteFruit(' + response.id + ')">Delete</button>' +
                    '</div>';
            });

            htmlOutput += '</div>';
            document.getElementById("data").innerHTML = htmlOutput;
        }
    });
}
let deleteFruit = (id) => {
    var details = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username'),
        "id": id
    };

    var url = 'http://localhost/principle/fruit/delete/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(details),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {

        },
        error: function (e) {
            console.log(e);
        }
    });
}

function displayAllUpdate() {
    var details = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username'),
        "name": $('#vegnameToUpdate').val()
    };

    var url = 'http://localhost/principle/vegetables/fetchByName/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(details),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            if (response != 'Required fields not filled') {
                let htmlOutput = '<div class="fetchAllWrapper">';
                htmlOutput += '<div class="fetchAllTab">' +
                    '<form onsubmit="return false">' +
                    '<div class="form-group">' +
                    '<input type="hidden" value="' + response[0].id + '" id="id">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].name + '" id="updateVName">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].type + '" id="updateVType">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].sowMonth + '" id="updateVSM">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].harvestMonth + '" id="updateVHM">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].minTemp + '" id="updateVMT">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].soilType + '" id="updateVST">' +
                    '</div>' +
                    '<button type="submit" class="updateBtn" onclick="updateVeg()">Update</button>' +
                    '</form>' +
                    '</div>';
                htmlOutput += '</div>';
                document.getElementById("data").innerHTML = htmlOutput;
            } else {
                document.querySelector(".responseUpdate").innerHTML = 'Required fields not filled';
            }
        }
    });
}

function updateVeg() {
    let data = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username'),
        "id": $('#id').val(),
        "name": $('#updateVName').val(),
        "type": $('#updateVType').val(),
        "sowMonth": $('#updateVSM').val(),
        "harvestMonth": $('#updateVHM').val(),
        "minTemp": $('#updateVMT').val(),
        "soilType": $('#updateVST').val()
    };
    var url = 'http://localhost/principle/vegetables/update/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(data),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            if (response.Status === 'Success') {
                document.querySelector('.responseUpdate').innerHTML = 'Successfuly updated';
            } else {
                document.querySelector('.responseUpdate').innerHTML = 'Unsuccessful';
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}

function displayAllFruitUpdate() {
    var details = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username'),
        "name": $('#fruitnameToUpdate').val()
    };

    var url = 'http://localhost/principle/fruit/fetchByName/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(details),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            if (response != 'Required fields not filled') {
                let htmlOutput = '<div class="fetchAllWrapper">';
                htmlOutput += '<div class="fetchAllTab">' +
                    '<form onsubmit="return false">' +
                    '<div class="form-group">' +
                    '<input type="hidden" value="' + response[0].id + '" id="Fid">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].name + '" id="updateFName">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].type + '" id="updateFType">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].plantingMonth + '" id="updateFPM">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].harvestMonth + '" id="updateFHM">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<input type="text" value="' + response[0].soilType + '" id="updateFST">' +
                    '</div>' +
                    '<button type="submit" class="updateBtn" onclick="updateFruit()">Update</button>' +
                    '</form>' +
                    '</div>';
                htmlOutput += '</div>';
                document.getElementById("data").innerHTML = htmlOutput;
            } else {
                document.querySelector(".responseUpdateTwo").innerHTML = 'Required fields not filled';
            }
        }
    });
}
let updateFruit = () => {
    let data = {
        "token": localStorage.getItem('token'),
        "username": localStorage.getItem('username'),
        "id": $('#Fid').val(),
        "name": $('#updateFName').val(),
        "type": $('#updateFType').val(),
        "plantingMonth": $('#updateFPM').val(),
        "harvestMonth": $('#updateFHM').val(),
        "soilType": $('#updateFST').val()
    };
    var url = 'http://localhost/principle/fruit/update/';
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify(data),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            if (response.Status === 'Success') {
                document.querySelector('.responseUpdateTwo').innerHTML = 'Successfuly updated';
            } else {
                document.querySelector('.responseUpdateTwo').innerHTML = 'Unsuccessful';
                console.log(data);
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}
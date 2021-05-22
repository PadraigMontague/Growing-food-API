let data = {
    "token":  "Enter token here",
    "username": "Test1",
};

//let url = "http://localhost/principle/vegetables/calculate/";
//let url ="http://localhost/principle/vegetables/weather/";
//let url ="http://localhost/principle/vegetables/searchSowMonth/";
//let url ="http://localhost/principle/vegetables/fetchAll/";
//let url ="http://localhost/principle/vegetables/fetchByName/";
//let url ="http://localhost/principle/fruit/fetchByName/";
let url ="http://localhost/principle/fruit/fetchAll/";
let amount = 0;
for (let i = 0; i <= 499; i++) {
    let intitialDate = (new Date()).getTime();
    fetch(url, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        }).then(response => response.json())
        .then((amount = amount + ((new Date()).getTime() - intitialDate)))
   console.log(amount);
}
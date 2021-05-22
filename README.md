# Growing food API
This webservice provides information about growing fruit and vegetables. However there is CRUD (create, read, updated and delete) functionality which allows the administrator of the API service to add new growing data as they see fit. There are multiple microservices in this project. The authentication microservice uses JWT (Json web tokens) to authenticate users when calling the API endpoints. The reporting microservice stores API analytics such as endpoint name, date, username and HTTP method used. This also ensures that there isn't any misuse of the webservice as the administrator will be able to view any attempted unauthorised access. The primary microservice is comprised of two webservices: vegetables and fruit. These webservices contain the functionality to view and add new growing information. Both the authentication and reporting service will be  utilised upon the call of any endpoints.

## Technologies used
    Core technologies:
        - PHP 7 
        - MySQL 
    Unit testing:
        - phpunit

## List of microservices
        - authentication
        - primary (contains two microservices)
        - report

## How to run the project?
    To run the project download the project using git or as a zip file.
    Download the following dependencies:
        - firebase JWT (Once downloaded create a libs folder at this path: Growing-food-API/authentication/. Then place the files into the libs folder.)
        - json_path (Once downloaded create a json_path folder at this path: Growing-food-API/principle/vegetables/. Then place the files into the json_path folder)

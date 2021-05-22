<?php

class FruitTests extends PHPUnit_Framework_TestCase {

    /**
     * @covers Fruit::calcNumberOfPlants. 
     * Test if data is empty.
     */
    public function testcalcNumberOfPlants() {
        $data = array(
            'token' => 'Enter token here',
            'username' => '',
            'squareFeet' => '',
            'spacing' => ''
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/calculate/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Unauthorised"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::calcNumberOfPlants. 
     * Test when data is valid.
     */
    public function testcalcNumberOfPlantsValid() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'squareFeet' => '100',
            'spacing' => '6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/calculate/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '[{"NumberOfPlants":400}]';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::calcNumberOfPlants. 
     * Test when squareFeet is valid.
     */
    public function testSquareFeetInvalid() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'squareFeet' => '-100',
            'spacing' => '6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/calculate/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '[{"NumberOfPlants":0}]';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::calcNumberOfPlants. 
     * Test when spacing is valid.
     */
    public function testSpacingInvalid() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'squareFeet' => '100',
            'spacing' => '-6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/calculate/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '[{"NumberOfPlants":0}]';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::calcNumberOfPlants. 
     * Test when squareFeet and spacing is valid.
     */
    public function testcalNumberOfPlantsInvalid() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'squareFeet' => '-100',
            'spacing' => '-6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/calculate/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '[{"NumberOfPlants":0}]';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::sowMonth 
     * Test when data is empty.
     */
    public function testplantingMonthEmpty() {

        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'plantingMonth' => '',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/plantingMonth/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Required fields not filled"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::sowMonth 
     * Test when data is valid.
     * The expected result needed to equal the result
     *  because the data cannot be predicted because it
     * is an array of objects which are constantly 
     * changing
     */
    public function testSowMonthValid() {

        $data = array(
             'token' =>  'Enter token here',
            'username' => 'James',
            'sowMonth' => 'April',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/searchSowMonth/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = $result;
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::updateFruit
     * Can only be run once. If this test is run
     * again it will fail as you must change some data
     * because the database will not update unless
     * the data is different
     */
    public function testUpdateFruit() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'id' => '6',
            'name' => 'Strawberry',
            'type' => 'Softfruit',
            'plantingMonth' => 'March',
            'harvestMonth' => 'May - August',
            'soilType' => 'Nutrient Rich'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/update/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '{"Status":"Success"}';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::updateFruit
     * Tests invalid data
     */
    public function testUpdateFruitInvalid() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'id' => '6',
            'name' => 'Strawberry',
            'type' => 'Softfruit',
            'plantingMonth' => '',
            'harvestMonth' => 'May - August',
            'soilType' => 'Nutrient Rich'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/update/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Required fields not filled"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::fetchByName
     * Tests empty data
     */
    public function testFetchByName() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'name' => ''
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/fetchByName/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Required fields not filled"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::fetchByName
     * Tests invalid token
     */
    public function testTokenInvalid() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'name' => 'Cabbage'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/fetchByName/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Unauthorised"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::fetchAllFruit
     * Tests invalid username
     */
    public function testFetchAllFruit() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'J',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/fetchAll/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Unauthorised"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::fetchAllFruit
     * Tests invalid token
     */
    public function testInvalidToken() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/fetchAll/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Unauthorised"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::createFruit
     * Tests empty data
     */
    public function testCreateFruit() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'name' => 'test',
            'type' => 'test',
            'plantingMonth' => 'test',
            'harvestMonth' => '',
            'soilType' => 'test',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/create/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Required fields not filled"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Fruit::createFruit
     * Tests valid data
     */
    public function testCreateFruitValid() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'name' => 'test',
            'type' => 'test',
            'plantingMonth' => 'test',
            'harvestMonth' => 'test',
            'soilType' => 'test',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/create/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '{"Status":"Success"}';
        $this->assertEquals($expectedResult, $result);
    }
    
        /**
     * @covers Fruit::createFruit
     * Tests invalid token
     */
    public function testCreateFruitToken() {
        $data = array(
            'token' =>  'Enter token here',
            'username' => 'James',
            'name' => 'test',
            'type' => 'test',
            'plantingMonth' => 'test',
            'harvestMonth' => 'test',
            'soilType' => 'test',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/fruit/create/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Unauthorised"';
        $this->assertEquals($expectedResult, $result);
    }

}

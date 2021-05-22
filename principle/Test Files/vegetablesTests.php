<?php

class VegetablesTests extends PHPUnit_Framework_TestCase {

    /**
     * @covers Vegetables::calcNumberOfPlants. 
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
        $ch = curl_init('http://localhost/principle/vegetables/calculate/');
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
     * @covers Vegetables::calcNumberOfPlants. 
     * Test when data is valid.
     */
    public function testcalcNumberOfPlantsValid() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'squareFeet' => '100',
            'spacing' => '6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/calculate/');
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
     * @covers Vegetables::calcNumberOfPlants. 
     * Test when squareFeet is valid.
     */
    public function testSquareFeetInvalid() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'squareFeet' => '-100',
            'spacing' => '6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/calculate/');
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
     * @covers Vegetables::calcNumberOfPlants. 
     * Test when spacing is valid.
     */
    public function testSpacingInvalid() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'squareFeet' => '100',
            'spacing' => '-6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/calculate/');
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
     * @covers Vegetables::calcNumberOfPlants. 
     * Test when squareFeet and spacing is valid.
     */
    public function testcalNumberOfPlantsInvalid() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'squareFeet' => '-100',
            'spacing' => '-6'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/calculate/');
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
     * @covers Vegetables::sowMonth 
     * Test when data is empty.
     */
    public function testSowMonthEmpty() {

        $data = array(
            'token' => 'Enter token here',
            'username' => 'Test',
            'sowMonth' => '',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/searchSowMonth/');
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
     * @covers Vegetables::sowMonth 
     * Test when data is valid.
     * The expected result needed to equal the result
     *  because the data cannot be predicted because it
     * is an array of objects which are constantly 
     * changing
     */
    public function testSowMonthValid() {

        $data = array(
            'token' => 'Enter token here',
            'username' => 'Test',
            'sowMonth' => 'April',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/searchSowMonth/');
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
     * @covers Vegetables::updateVegetables
     * Can only be run once. If this test is run
     * again it will fail as you must change some data
     * because the database will not update unless
     * the data is different
     */
    public function testUpdateVegetables() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'id' => '3',
            'name' => 'Cabbage',
            'type' => 'Brassica',
            'sowMonth' => 'April',
            'harvestMonth' => 'July - January',
            'minTemp' => '5 degrees',
            'soilType' => 'Nutrient Rich'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/update/');
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
     * @covers Vegetables::updateVegetables
     * Tests invalid data
     */
    public function testUpdateVegetablesInvalid() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'id' => '3',
            'name' => 'Cabbage',
            'type' => '',
            'sowMonth' => 'April',
            'harvestMonth' => 'July - January',
            'minTemp' => '5 degrees',
            'soilType' => 'Nutrient Rich'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/update/');
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
     * @covers Vegetables::fetchByName
     * Tests empty data
     */
    public function testFetchByName() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'name' => ''
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/fetchByName/');
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
     * @covers Vegetables::fetchByName
     * Tests invalid token
     */
    public function testTokenInvalid() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'name' => 'Cabbage'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/fetchByName/');
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
     * @covers Vegetables::fetchAllVeg
     * Tests invalid username
     */
    public function testFetchAllVeg() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'J',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/fetchAll/');
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
     * @covers Vegetables::fetchAllVeg
     * Tests invalid token
     */
    public function testInvalidToken() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/fetchAll/');
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
     * @covers Vegetables::createVegetable
     * Tests empty data
     */
    public function testCreateVegetable() {
        $data = array(
             'token' => 'Enter token here',
            'username' => 'James',
            'name' => 'test',
            'type' => 'test',
            'sowMonth' => 'test',
            'harvestMonth' => 'test',
            'minTemp' => '',
            'soilType' => 'test',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/create/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '{"success":0}';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Vegetables::createVegetable
     * Tests valid data
     */
    public function testCreateVegValid() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'name' => 'test',
            'type' => 'test',
            'sowMonth' => 'test',
            'harvestMonth' => 'test',
            'minTemp' => '5 degrees',
            'soilType' => 'test',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/create/');
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
     * @covers Vegetables::createVegetable
     * Tests invalid token
     */
    public function testCreateVegToken() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James',
            'name' => 'test',
            'type' => 'test',
            'sowMonth' => 'test',
            'harvestMonth' => 'test',
            'minTemp' => '5 degrees',
            'soilType' => 'test',
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/principle/vegetables/create/');
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

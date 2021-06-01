<?php


namespace Tests\Traits;


use Illuminate\Foundation\Testing\TestResponse;

trait TestSaves
{
    protected  abstract  function model();
    protected  abstract  function routeStore();
    protected  abstract  function routeUpdate();

    protected  function assertStore(array $sendData, array $testData,array $testJsonData=null)
    {

        $response =$this->json('POST',$this->routeStore(),$sendData);

        if($response->status()!==201){
            throw new \Exception("Response status must be 201, given {$response->status()}:\n{$response->content()}");
        }

        $this->assertInDataBase($response,$testData);
        $this->assertJsonResponseContent($response,$testData,$testJsonData);

    }

    protected function assertUpdate(array $sendData, array $testData,array $testJsonData=null)
    {
        $response = $this->json('PUT',$this->routeUpdate(),$sendData);
        if($response->status()!==200){
            throw new \Exception("Response status must be 200, given {$response->status()}:\n{$response->content()}");
        }
        $this->assertInDataBase($response,$testData);
        $this->assertJsonResponseContent($response,$testData,$testJsonData);

    }

    private function assertInDataBase(TestResponse  $response, array $testData)
    {
        $model = $this->model();
        $table =(new $model)->getTable();
        $this->assertDataBaseHas($table,$testData+['id'=>$response->json('id')]);
    }
    private function assertJsonResponseContent(TestResponse $response, array $testData, array $testJsonData = null){

        $testResponse = $testJsonData ?? $testData;
        $response->assertJsonFragment($testResponse+['id'=>$response->json('id')]);
    }

}

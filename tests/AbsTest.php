<?php


abstract class AbsTest extends TestCase
{

    public $negative_user_id;
    public $positive_user_id;
    public $method;
    public $url;
    public $positive_parameters;
    public $negative_parameters;
    public $token;

    public function __construct($method,$url,$positive_user_id, $negative_user_id, $positive_parameters, $negative_parameters)
    {
        parent::__construct();
        $this->method = $method;
        $this->url = $url;
        $this->positive_user_id = $positive_user_id;
        $this->negative_user_id = $negative_user_id;
        $this->negative_parameters = $negative_parameters;
        $this->positive_parameters = $positive_parameters;
    }
    public function setUp()
    {
        parent::setUp();

        $this->artisan("db:seed");
        if($this->positive_user_id != null){
            $user = \App\User::find($this->positive_user_id);
            $this->token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        }

        $this->refreshApplication();


    }


    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            \Illuminate\Support\Facades\DB::disconnect();
        });

        parent::tearDown();
    }
    /**
     * Positive Test
     *
     * @return void
     */
    public function testPositive()
    {
        $this->executeCall($this->positive_parameters, false);
    }

    /**
     * Este test comprueba los campos que son requeridos
     */
    public function testNegativeRequiredParameters()
    {
        if(count($this->positive_parameters) > 0){
            $this->executeCall(array(), true);
        }
    }

    /**
     * Este test comprueba que tienes que tener permisos para utilizar este servicio
     */
    public function testNegativePermissions()
    {
        if($this->negative_user_id != null){
            $user = \App\User::find($this->negative_user_id);
            $this->token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

            $this->refreshApplication();

            $this->executeCall($this->positive_parameters, true);
        }
    }
    /**
     * Este test comprueba que los parametros pasados tienen valores correctos
     */
    public function testNegativeParameters()
    {
        if($this->negative_parameters != null){
            foreach ($this->negative_parameters as $parameters){
                $this->executeCall($parameters, true);
            }
        }

    }

    private function executeCall($parameters, $error){
        $json = $this->json($this->method, $this->url,
            $parameters
            ,array(
                'Authorization' => 'Bearer '. $this->token
            )
        );


        $json->seeJson([
                'error' => $error,
            ]);
    }


}

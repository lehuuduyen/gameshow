<?php
	
	namespace App\Http\Controllers;
	use Dingo\Api\Routing\Helpers;
	use Illuminate\Routing\Controller;
	use Illuminate\Support\Facades\Redirect;
	use Session;

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Psr7;


	class BaseController extends Controller{
		use Helpers;
		const STATUS_SUCCESS = 200;
		// 201	Created - Your resource had been created (come with POST method).
		const STATUS_CREATED = 201;
		// 204	No Content - Your resource had been deleted (come with DELETE method).
		const STATUS_DELETED           = 204;
		const STATUS_NO_CONTENT        = 204;
		const STATUS_BAD_REQUEST       = 400;
		const STATUS_NOT_AUTHORIZE     = 401;
		const STATUS_NOT_FOUND         = 404;
		const STATUS_CONFLICT_RESOURCE = 409;
		const STATUS_SERVER_ERROR      = 500;
		const STATUS_PERMISSION_DENIED = 550;
		protected function responseSuccess( $data = NULL,$message = '',$key = NULL ){
			$data = (object)[
				'data'        => $data,
				'message'     => $message,
				'code'        => $key,
				'status_code' => static::STATUS_SUCCESS
			];
			if( $key ){
				$data->msg = \Lang::get( $key );
			}
			
			return response()->json( $data,static::STATUS_SUCCESS );
		}
		protected function responseNoContent(){
			$data = (object)[
				'data'        => NULL,
				'message'     => '',
				'status_code' => static::STATUS_NO_CONTENT
			];
			
			return response()->json( $data,static::STATUS_NO_CONTENT );
		}
		protected function responseData( $data = NULL,$message = '',$key = NULL,$status = '' ){
			if( $status == '' ){
				$status = static::STATUS_SUCCESS;
			}
			$data = (object)[
				'data'        => $data,
				'message'     => '',
				'code'        => '',
				'status_code' => $status
			];
			
			return response()->json( $data,$status );
		}
		protected function responseCreated( $data = NULL,$message = '',$key = NULL ){
			$data = (object)[
				'data'        => $data,
				'message'     => $message,
				'code'        => $key,
				'status_code' => static::STATUS_CREATED
			];
			if( $key ){
				$data->msg = \Lang::get( $key );
			}
			
			return response()->json( $data,static::STATUS_CREATED );
		}
		public function responseDeleted( $data = NULL ){
			return response()->json( $data,static::STATUS_DELETED );
		}
		public function responseBad( $message,$data = NULL,$key = NULL ){
			$newData = [
				'data'        => $data,
				//'msg_origin' => $message,
				'message'     => $message,
				'code'        => $key,
				'status_code' => static::STATUS_BAD_REQUEST
			];
			
			return response()->json( $newData,static::STATUS_BAD_REQUEST );
		}
		public function responseServerError( $message,$data = NULL,$key = NULL ){
			$newData = [
				'data'        => $data,
				'message'     => $message,
				'code'        => $key,
				'status_code' => static::STATUS_SERVER_ERROR
			];
			
			return response()->json( $newData,static::STATUS_SERVER_ERROR );
		}
		public function responsePermissionDenied( $message = "Access rights denied.",$data = NULL,$key = NULL ){
			$newData = [
				'data'        => NULL,
				'message'     => $message,
				'code'        => "",
				'status_code' => static::STATUS_PERMISSION_DENIED
			];
			
			return response()->json( $newData,static::STATUS_PERMISSION_DENIED );
		}

		public function responseNotFound($message = 'Not Found') {
            $newData = [
                'data'        => NULL,
                'message'     => $message,
                'code'        => "",
                'status_code' => static::STATUS_NOT_FOUND
            ];

            return response()->json($newData, static::STATUS_NOT_FOUND);
        }
		//return for view
		public function redirectErrors( $messages = [] ){
			
		}
		public function redirectError( $messages = [] ){
			session()->flash( 'error',$messages );
			
			return Redirect::back();
		}
		public function redirectSuccess( $messages = [] ){
			session()->flash( 'success',$messages );
			
			return Redirect::back();
		}


		public function getUser(){
            $userData        = (object)session( 'userData' );
            return $userData;
        }

        public function getEmployee($id){
            $client = new Client();

            $response = $client->request( 'get',getenv( 'URL_LOGIN_GET_EMPLOYEE_BY_USER' ).$id ,[
                'headers'     => [
                    'Authorization' => session( 'token' ),
                ],
                'http_errors' => TRUE
            ] );

            $body     = $response->getBody();
            $data  = json_decode( $body )->data;

            return $data;
        }
        public function always_tracking($id){
            $client = new Client();

            $response = $client->request( 'get',getenv( 'URL_LOGIN_GET_ALWAYS_TRACKING' ).$id ,[
                'headers'     => [
                    'Authorization' => session( 'token' ),
                ],
                'http_errors' => TRUE
            ] );

            $body     = $response->getBody();
            $data  = json_decode( $body );

            return $data;
        }

        public function getUser_Department($id){
            $client = new Client();

            $response = $client->request( 'get',getenv( 'URL_LOGIN_GET_USER_BY_DEPARTMENT' ).$id ,[
                'headers'     => [
                    'Authorization' => session( 'token' ),
                ],
                'http_errors' => TRUE
            ] );

            $body     = $response->getBody();
            $data  = json_decode( $body )->data;

            return $data;
        }
        public function getAllEmployee($array=[]){
            $client = new Client();
            $response = $client->request( 'post',getenv( 'URL_LOGIN_GET_USER' ) ,[
                'headers'     => [
                    'Authorization' => session( 'token' ),
                ],
                'query' => $array,
                'http_errors' => TRUE
            ] );
            $code     = $response->getStatusCode(); // 200
            $body     = $response->getBody();
            $arrBody  = json_decode( $body, true )['data'];

            return $arrBody;
        }




	}
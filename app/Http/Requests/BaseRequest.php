<?php
	
	namespace App\Http\Requests;
    use Dingo\Api\Http\FormRequest;
	class BaseRequest extends FormRequest{
		/**
		 * Get only filed validation
		 * And support add user_id to data request
		 *
		 * @param bool $hasUserID
		 * @return array
		 */
		public function dataOnly( $hasUserID = FALSE ){
			$data = $this->only( array_keys( $this->rules() ) );
			if( $hasUserID ){
				$userData        = (object)session( 'userData' );
				$data['user_id'] = $userData->id;
			}
            foreach ($data as $key => $value) {
                if($data[ $key ] == 0){

                }
                if ($data[ $key ] == "" || $data[ $key ] == NULL) {
                    unset($data[ $key ]);
                }

            }

            return $data;
		}
	}

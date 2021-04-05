<?php


namespace App\Services;


use App\Jobs\GetFriendsJob;
use App\Models\VkUser;
use GuzzleHttp\Client;

class VkService
{
        private function callApi($id){

            $url = config('services.vk.url') . 'friends.get';



            $client = new Client();

            $response = $client->request('GET', $url, [
                'query' =>[
                    'user_id' => $id,
                    'access_token' => config('services.vk.token'),
                    'v' => config('services.vk.version'),
                    'fields' => 'first_name,last_name,id',
                    ]
            ]);
            return json_decode($response->getBody()->getContents(), true)['response']['items'] ?
                json_decode($response->getBody()->getContents(), true)['response']['items'] : null;
        }

        public function getFriends($id, $recursive = false){

            $friends = $this->callApi($id);

            foreach ($friends ?? [] as $friend){
                if(!VkUser::where('vk_id', $friend['id'])->exists()){
                    $user = VkUser::create([
                        'vk_id' => $friend['id'],
                        'first_name' => $friend['first_name'],
                        'last_name' => $friend['last_name']
                    ]);

                    if($recursive){
                        GetFriendsJob::dispatch($user);
                    }
                }
            }
        }

}

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use App\Character;

class BattlenetController extends Controller
{

    public function submit(Request $request){

        $myClient = new Client([
            'headers' => ['User-Agent' => 'MyReader']
        ]);

        try {

            $this->validate($request, [
                'feed_name' => 'required',
                'feed_realm' => 'required'
            ]);

            $name = $request->input('feed_name');
            $realm = $request->input('feed_realm');
            $base_url = "https://eu.api.battle.net/wow/character/";
            $url_atrributes_field = "?fields=";
            $url_attributes_locale_api_key = "&locale=en_GB&apikey=pk6erm2brgq7zmyxvty5s4hkan44bnqw";

            //pvp information
            $url = $base_url . "/" . $realm . "/". $name . $url_atrributes_field. "pvp" . $url_attributes_locale_api_key;
            $pvp_response = $myClient->request('GET', $url);

            //item information
            $url = $base_url . "/" . $realm . "/" . $name . $url_atrributes_field . "items" . $url_attributes_locale_api_key;
            $item_response = $myClient->request('GET' , $url);

            //guild information
            $url = $base_url . "/" . $realm . "/" . $name . $url_atrributes_field . "guild" . $url_attributes_locale_api_key;
            $guild_response = $myClient->request('GET' , $url);

        } catch (GuzzleException $e) {
            //
        }
        if (!empty($pvp_response)
            && !empty($item_response)
            && !empty($guild_response)){

            if ($pvp_response->getStatusCode() == 200
                && $item_response->getStatusCode() == 200
                && $guild_response->getStatusCode() == 200){

                $pvp_body = $pvp_response->getBody();
                $pvp_json = json_decode($pvp_body, true);

                $item_body = $item_response->getBody();
                $item_json = json_decode($item_body, true);

                $guild_body = $guild_response->getBody();
                $guild_json = json_decode($guild_body, true);

                $nameRealm = $pvp_json['name'] . "-" . $pvp_json['realm'];

                $character = DB::table('characters')->where('name-realm' , $nameRealm)->first();
                if ($character === null) {
                    // character doesn't exist
                    $character = new Character([
                        'name-realm' => $nameRealm
                    ]);

                    $character->save();
                }else{
                    DB::table('characters')
                        ->where('name-realm',$nameRealm)
                        ->update(
                            [
                                'name-realm' => $nameRealm,
                                'updated_at' => \Carbon\Carbon::now()
                            ]);
                }

                $db_characters = DB::table('characters')
                    ->latest()
                    ->get()
                    ->toJson();

                return view('pages.home')->with('pvp_json', $pvp_json)->with('item_json' , $item_json)->with('guild_json' , $guild_json)->with('characters' , $db_characters);
            }
        }else{
            return view('pages.home')->with('pvp_json', [])->with('guild_json', [])->with('item_json', []);
        }
    }
}


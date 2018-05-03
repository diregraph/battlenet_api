<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Character;
use function MongoDB\BSON\toJSON;

class BattlenetController extends Controller
{

    public function submit(Request $request)
    {

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
            $url = $base_url . "/" . $realm . "/" . $name . $url_atrributes_field . "pvp" . $url_attributes_locale_api_key;
            $pvp_response = $myClient->request('GET', $url);

            //item information
            $url = $base_url . "/" . $realm . "/" . $name . $url_atrributes_field . "items" . $url_attributes_locale_api_key;
            $item_response = $myClient->request('GET', $url);

            //guild information
            $url = $base_url . "/" . $realm . "/" . $name . $url_atrributes_field . "guild" . $url_attributes_locale_api_key;
            $guild_response = $myClient->request('GET', $url);

        } catch (GuzzleException $e) {
            //
        }
        if (!empty($pvp_response) &&
            !empty($item_response) &&
            !empty($guild_response)) {

            if ($pvp_response->getStatusCode() == 200 &&
                $item_response->getStatusCode() == 200 &&
                $guild_response->getStatusCode() == 200) {

                $pvp_body = $pvp_response->getBody();
                $pvp_json = json_decode($pvp_body, true);

                $item_body = $item_response->getBody();
                $item_json = json_decode($item_body, true);

                $guild_body = $guild_response->getBody();
                $guild_json = json_decode($guild_body, true);

                $nameRealm = $pvp_json['name'] . "-" . $pvp_json['realm'];

                $character = DB::table('characters')->where('name-realm', $nameRealm)->first();
                if ($character === null) {
                    // character doesn't exist
                    $character = new Character([
                        'name-realm' => $nameRealm
                    ]);

                    $character->save();
                } else {
                    DB::table('characters')
                        ->where('name-realm', $nameRealm)
                        ->update(
                            [
                                'name-realm' => $nameRealm,
                                'updated_at' => \Carbon\Carbon::now()
                            ]);
                }

                $characters = DB::table('characters')
                    ->orderBy('updated_at', 'desc')
                    ->paginate(50);

                return view('pages.home')->with('pvp_json', $pvp_json)
                    ->with('item_json', $item_json)
                    ->with('guild_json', $guild_json)
                    ->with('characters', $characters);
            }
            $characters = DB::table('characters')
                ->orderBy('updated_at', 'desc')
                ->paginate(50);

            return view('pages.home')->with('pvp_json', [])
                ->with('guild_json', [])
                ->with('item_json', [])
                ->with('characters', $characters);
        } else {
            $characters = DB::table('characters')
                ->orderBy('updated_at', 'desc')
                ->paginate(50);

            return view('pages.home')->with('pvp_json', [])
                ->with('guild_json', [])
                ->with('item_json', [])
                ->with('characters', $characters);
        }
    }

    public function bracket(Request $request)
    {
        $myClient = new Client([
            'headers' => ['User-Agent' => 'MyReader']
        ]);

        $this->validate($request, [
            'feed_bracket' => 'required'
        ]);
        $bracket = $request->input('feed_bracket');

        try {
            $base_url = "https://eu.api.battle.net/wow/leaderboard/";
            $url_attributes_locale_api_key = "?locale=en_GB&apikey=pk6erm2brgq7zmyxvty5s4hkan44bnqw";

            //pvp leaderboard information
            $url = $base_url . $bracket . $url_attributes_locale_api_key;
            $pvp_leaderboard_response = $myClient->request('GET', $url);
        } catch (GuzzleException $e) {
            //
        }

        if (!empty($pvp_leaderboard_response)) {

            if ($pvp_leaderboard_response->getStatusCode() == 200) {

                $pvp_leaderboard_body = $pvp_leaderboard_response->getBody();
                $pvp_leaderboard_json = json_decode($pvp_leaderboard_body, true);

                foreach ($pvp_leaderboard_json['rows'] as $character) {
                    $nameRealm = $character['name'] . '-' . $character['realmName'];
                    $db_character = DB::table('leaderboard')->where('name-realm', $nameRealm)->first();
                    if ($db_character === null) {
                        try {
                            $base_url = "https://eu.api.battle.net/wow/character/";
                            $url_attributes_locale_api_key = "?fields=appearance&locale=en_GB&apikey=pk6erm2brgq7zmyxvty5s4hkan44bnqw";

                            $url = $base_url . $character['realmName'] . '/' . $character['name'] . $url_attributes_locale_api_key;
                            $character_appearance_response = $myClient->request('GET', $url);
                        } catch (GuzzleException $e) {
                            //
                        }
                        if (!empty($character_appearance_response) && $character_appearance_response->getStatusCode() == 200) {
                            $character_appearance_json = json_decode($character_appearance_response->getBody(), true);
                            DB::table('leaderboard')
                                ->insert(
                                    [
                                        'name-realm' => $nameRealm,
                                        'thumbnail' => $character_appearance_json['thumbnail'],
                                        $bracket => $character['rating'],
                                        'ranking_' . $bracket => $character['ranking'],
                                        'created_at' => \Carbon\Carbon::now(),
                                        'updated_at' => \Carbon\Carbon::now()
                                    ]);
                        }
                    } else {
                        $db_leaderboard_character = json_decode(json_encode($db_character), true);
                        if ($db_leaderboard_character[$bracket] === $character['rating'] && $db_leaderboard_character['ranking_' . $bracket] === $character['ranking']) {
                            continue;
                        } else {
                            DB::table('leaderboard')
                                ->where('name-realm', $nameRealm)
                                ->update(
                                    [
                                        $bracket => $character['rating'],
                                        'ranking_' . $bracket => $character['ranking'],
                                        'updated_at' => \Carbon\Carbon::now()
                                    ]);
                        }
                    }
                }

                $leaderboard = DB::table('leaderboard')
                    ->orderBy('2v2', 'desc')
                    ->paginate(50);

                return view('pages.ranking')->with('pvp_leaderboard_json', $pvp_leaderboard_json)->with('leaderboard', $leaderboard);
            }
            return view('pages.ranking')->with('pvp_leaderboard_json', []);
        } else {
            return view('pages.ranking')->with('pvp_leaderboard_json', []);
        }


    }

    public function sort(Request $request)
    {
        $sort_bracket = $request->input('sort_bracket');
        if ($sort_bracket != null) {
            $leaderboard = DB::table('leaderboard')
                ->orderBy($sort_bracket, 'desc')
                ->paginate(50);

            return view('pages.ranking')->with('leaderboard', $leaderboard)->with('sort_bracket', $sort_bracket);
        } else {
            $leaderboard = DB::table('leaderboard')
                ->orderBy('2v2', 'desc')
                ->paginate(50);

            return view('pages.ranking')->with('leaderboard', $leaderboard)->with('sort_bracket', '2v2');
        }
    }

}


@extends('layouts.default')

@section('title')
    @if(!empty($pvp_json))
        {{$pvp_json["name"]}}-{{$pvp_json["realm"]}}
    @else
        Home
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col border-primary border p-3">
            <form action="{{route('submit-url')}}" method="POST">
                @csrf
                <input name="feed_name" placeholder="Name" aria-required="true">
                <input name="feed_realm" placeholder="Realm" aria-required="true">
                <input type="submit" value="Check">
            </form>
            <br>
            <table class="table table-hover">
                <thead>
                <tr class="table-active">
                    <th scope="col">Name-Realm</th>
                    <th scope="col">Last Checked</th>
                    <th scope="col">Highest Stats</th>
                </tr>
                </thead>
                <tbody>
                {{--{{dd(json_decode($characters,true)[0]['name-realm'])}}--}}
                @foreach (json_decode($characters,true) as $character)
                <tr>
                    <td>{{$character['name-realm']}}</td>
                    <td>{{$character['updated_at']}}</td>
                    <td>Column content</td>
                </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        @if(!empty($pvp_json))
        <div class="col border-primary border" id="withBg"
             style="background-image: url('http://render-eu.worldofwarcraft.com/character/{!! str_replace('avatar', 'main', $pvp_json["thumbnail"]) !!}');">

            <div class="p-3" style="background-color:rgba(0, 0, 0, 0.7);">
                <div class="row">
                    <div class="col">
                        <h1>{{$pvp_json["name"]}}-{{$pvp_json["realm"]}}</h1>
                        @if(array_key_exists("guild" , $guild_json))
                        <h4>< {{$guild_json["guild"]["name"]}} ></h4>
                        @endif
                        <h4>Average item level equipped : {{$item_json["items"]["averageItemLevelEquipped"]}}</h4>
                    </div>
                    <div class="col">
                        <h1>
                            <img src="{{ asset('achievements.gif') }}"
                                 alt="achievements"> {{$pvp_json["achievementPoints"]}}
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card border border-primary" style="width: 18rem;">
                            <img class="card-img-top"
                                 src="http://render-eu.worldofwarcraft.com/character/{{$pvp_json["thumbnail"]}}"
                                 alt="Card image cap">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>2v2 Arena Rating : </b>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_2v2"]["rating"]}}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Wins
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_2v2"]["seasonWon"]}}</a>
                                            <a class="dropdown-item" href="#">Losses
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_2v2"]["seasonLost"]}}</a>
                                            <a class="dropdown-item" href="#">Total
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_2v2"]["seasonPlayed"]}}</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item"><b>3v3 Arena Rating : </b>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_3v3"]["rating"]}}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Wins
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_3v3"]["seasonWon"]}}</a>
                                            <a class="dropdown-item" href="#">Losses
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_3v3"]["seasonLost"]}}</a>
                                            <a class="dropdown-item" href="#">Total
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_3v3"]["seasonPlayed"]}}</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item"><b>Battleground Rating : </b>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_RBG"]["rating"]}}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Wins
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_RBG"]["seasonWon"]}}</a>
                                            <a class="dropdown-item" href="#">Losses
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_RBG"]["seasonLost"]}}</a>
                                            <a class="dropdown-item" href="#">Total
                                                : {{$pvp_json["pvp"]["brackets"]["ARENA_BRACKET_RBG"]["seasonPlayed"]}}</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <h5 class="card-title">Character</h5>
                            <li class="list-group-item">Highest 2 man personal rating</li>
                            <li class="list-group-item">Highest 3 man personal rating</li>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Account</h5>
                            <a class="list-group-item">Achievement 1 </a>
                            <a class="list-group-item">Achievement 2</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @else
        <div class="col border-primary border p-3">
            Enter a valid Name and a Realm
        </div>
        @endif
    </div>
@stop
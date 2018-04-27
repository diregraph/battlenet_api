<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <title>Check WoW PvP</title>
</head>
<body>

<div class="container-fluid p-5">
    <div class="row">
        <div class="col border-primary border p-3">
            <form action="{{route('submit-url')}}" method="POST">
                @csrf
                Enter Name: <input name="feed_name">
                Enter Realm: <input name="feed_realm">
                <input type="submit" value="Check">
            </form>
        </div>
        <div class="col border-primary border p-3">
            @if(!empty($pvp_json))
                <div class="row">
                    <div class="col">
                        <h1>{{$pvp_json["name"]}}-{{$pvp_json["realm"]}}</h1>
                        <h4>< {{$guild_json["guild"]["name"]}} ></h4>
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
            @else
                Enter a valid Name and a Realm
            @endif
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
</body>
</html>



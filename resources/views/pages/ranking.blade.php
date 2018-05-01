@extends('layouts.default')

@section('title')
    Ranking
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
                    <th scope="col" style="width: 50px">Ranking</th>
                    <th scope="col" style="width: 100px"></th>
                    <th scope="col" style="width: 300px">Name-Realm</th>
                    <th class="text-center" scope="col" colspan="4">Current Season Rating</th>

                </tr>
                <tr class="table-active">
                    <th scope="col" style="width: 50px"></th>
                    <th scope="col" style="width: 100px"></th>
                    <th scope="col" style="width: 300px"></th>
                    <th scope="col">2v2</th>
                    <th scope="col">3v3</th>
                    <th scope="col">5v5</th>
                    <th scope="col">RBG</th>
                </tr>
                </thead>
                <tbody>
                @foreach (json_decode($leaderboard,true) as $row)
                    <tr>
                        <td>{{$row['ranking_2v2']}}</td>
                        <td>
                            <img src="http://render-eu.worldofwarcraft.com/character/{{$row['thumbnail']}}"
                                 style="width:50px;border:2px solid #9382c9">
                        </td>
                        <td>{{$row['name-realm']}}</td>
                        <td>{{$row['2v2']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div class="col border-primary border p-3">
            <br>
            <p>Bracket Examples: "2v2" , "3v3", "5v5", "rbg"</p>
            <form action="{{route('submit-bracket')}}" method="POST">
                @csrf
                <select name="feed_bracket" aria-required="true" title="Bracket">
                    <option value="2v2">2v2</option>
                    <option value="3v3">3v3</option>
                    <option value="5v5">5v5</option>
                    <option value="rbg">Rated Battleground</option>
                </select>
                <button type="submit">Check</button>
            </form>
            <br>
            @if(!empty($pvp_leaderboard_json))
                <table class="table table-hover">
                    <thead>
                    <tr class="table-active" style="height: 56px">
                        <th scope="col" style="width: 50px">Ranking</th>
                        <th scope="col" style="width: 100px"></th>
                        <th scope="col" style="width: 300px">Name-Realm</th>
                        <th scope="col">Current Season Rating</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--{{dd($pvp_leaderboard_json['rows'])}}--}}
                    @foreach ($pvp_leaderboard_json['rows'] as $character)

                        <tr style="height: 56px">
                            <td>{{$character['ranking']}}</td>
                            <td>
                                <img src="http://render-eu.worldofwarcraft.com/character/gordunni/14/167977230-avatar.jpg"
                                     style="width:50px;border:2px solid #9382c9">
                            </td>
                            <td>{{$character['name'] . "-" . $character['realmName']}}</td>
                            <td>{{$character['rating']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                Select a bracket to view leaderboard
                <br>
            @endif

        </div>
    </div>
@stop
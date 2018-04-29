@extends('layouts.default')

@section('title')
    Ranking
@endsection

@section('content')
    <div class="col border-primary border p-3">
        <form action="{{route('submit-url')}}" method="POST">
            @csrf
            <input name="feed_name" placeholder="Name" aria-required="true">
            <input name="feed_realm" placeholder="Realm" aria-required="true">
            <input type="submit" value="Check">
        </form>
    </div>
    <br>
    <div class="col border-primary border p-3">
        <br>
        <p>Bracket Examples: "2v2" , "3v3", "5v5", "rbg"</p>
        <form action="{{route('submit-bracket')}}" method="POST">
            @csrf
            <input name="feed_bracket" placeholder="Bracket" aria-required="true">
            <input type="submit" value="Check">
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
            Enter a bracket to view leaderboard
            <br>
        @endif

    </div>
@stop
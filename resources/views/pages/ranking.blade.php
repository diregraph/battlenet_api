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
            <br>
            <div class="d-flex justify-content-center">
                <div class="d-flex flex-column mb-3">
                    <form action="{{route('submit-bracket')}}" method="POST">
                        @csrf
                        <select name="feed_bracket" aria-required="true" title="Bracket">
                            <option value="2v2">2v2</option>
                            <option value="3v3">3v3</option>
                            <option value="5v5">5v5</option>
                            <option value="rbg">Rated Battleground</option>
                        </select>
                        <button class="btn btn-primary" type="submit">Check</button>
                    </form>
                    <form class="mt-3" action="{{route('sort-bracket')}}" method="GET">
                        @csrf
                        <select name="sort_bracket" aria-required="true" title="Bracket">
                            <option value="2v2"
                                    @if($sort_bracket === '2v2')
                                    selected="selected"
                                    @endif>
                                2v2
                            </option>
                            <option value="3v3"
                                    @if($sort_bracket === '3v3')
                                    selected="selected"
                                    @endif>
                                3v3
                            </option>
                            <option value="5v5"
                                    @if($sort_bracket === '5v5')
                                    selected="selected"
                                    @endif>
                                5v5
                            </option>
                            <option value="rbg"
                                    @if($sort_bracket === 'rbg')
                                    selected="selected"
                                    @endif>
                                Rated Battleground
                            </option>
                        </select>
                        <button class="btn btn-primary" type="submit">Sort</button>
                    </form>
                </div>
            </div>
            <br>
            <div class="d-flex justify-content-center">
                {{ $leaderboard->links() }}
            </div>
            <table class="table table-hover">
                <thead>
                <tr class="table-active">
                    <th scope="col" style="width: 50px">Ranking</th>
                    <th scope="col" style="width: 100px"></th>
                    <th scope="col" style="width: 300px">Name-Realm</th>
                    <th class="text-center" scope="col" colspan="4">Current Season Rating</th>
                    <th class="text-center" scope="col" colspan="4">Max Rating</th>

                </tr>
                <tr class="table-active">
                    <th scope="col" style="width: 50px"></th>
                    <th scope="col" style="width: 100px"></th>
                    <th scope="col" style="width: 300px"></th>
                    <th scope="col" style="width: 70px;">2v2</th>
                    <th scope="col" style="width: 70px;">3v3</th>
                    <th scope="col" style="width: 70px;">5v5</th>
                    <th scope="col" style="width: 70px;">RBG</th>
                    <th scope="col" style="width: 70px;">2v2</th>
                    <th scope="col" style="width: 70px;">3v3</th>
                    <th scope="col" style="width: 70px;">5v5</th>
                    <th scope="col" style="width: 70px;">RBG</th>
                </tr>
                </thead>
                <tbody>
                {{--{{dd($sort_bracket)}}--}}
                @foreach (json_decode(json_encode($leaderboard),true)['data'] as $row)
                    <tr>
                        <td>{{$row['ranking_'.$sort_bracket]}}</td>
                        <td>
                            <img src="http://render-eu.worldofwarcraft.com/character/{{$row['thumbnail']}}"
                                 style="width:50px;border:2px solid #9382c9">
                        </td>
                        <td>{{$row['name-realm']}}</td>
                        <td>{{$row['2v2']}}</td>
                        <td>{{$row['3v3']}}</td>
                        <td>{{$row['5v5']}}</td>
                        <td>{{$row['rbg']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $leaderboard->links() }}
            </div>
        </div>
        <br>
        {{--<div class="col border-primary border p-3">
            <br>
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
                    --}}{{--{{dd($pvp_leaderboard_json['rows'])}}--}}{{--
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
                <div class="p-3">
                    <div class="alert alert-primary">
                        Select a bracket to view leaderboard
                    </div>
                </div>
                <br>
            @endif
        </div>--}}
    </div>
@stop
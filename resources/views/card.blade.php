<div class="card col-sm-5 m-sm-2" id="pokemon_{{$objPokemon->id}}" style="width: 18rem;">
    <img src="{{$objPokemon->url_photo}}" class="card-img-top  m-sm-2" alt="..." width="100" height="100">
    <div class="card-body">
        <h4 class="card-title">{{$objPokemon->name}}</h4>
        <p class="card-text">Base experience: {{$objPokemon->base_experience}}<br>
            Height: {{$objPokemon->height}}<br>
            Weight: {{$objPokemon->weight}}<br>
        <h5>Stats</h5>
        @foreach(json_decode($objPokemon->stats,true) as $stats)
        {{$stats['stat']['name']}}: {{$stats['base_stat']}}<br>
        @endforeach
        </p>
        <a href="#" data-id="{{$objPokemon->id}}" data-url="{{$objPokemon->url_species}}" class="btn btn-primary"
            onclick="evolution(this)">Evolution</a>
        <a href="#" data-id="{{$objPokemon->id}}" class="btn btn-danger" onclick="deletePokemon(this)">Delete</a>
    </div>
</div>
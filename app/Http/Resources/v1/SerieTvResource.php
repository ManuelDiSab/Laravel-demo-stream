<?php

namespace App\Http\Resources\v1;

use App\Models\generi;
use App\Models\SeriePreferite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SerieTvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = "https://www.manueldisabatino.it/stream-backend/storage/app/public/img/";
        $idUser = Auth::user()->idUser;
        $preferito = SeriePreferite::where('idUSer', $idUser)->where('idSerie', $this->idSerie)->exists();
        return [
            'idSerie' => $this->idSerie,
            'idGenere' => $this->idGenere,
            "genere" => generi::where('idGenere', $this->idGenere)->valueOrFail('nome'), //Prendo solo il valore della colonna 
            'titolo' => $this->titolo,
            'trama' => $this->trama,
            'n_stagioni' => $this->n_stagioni,
            'anno' => $this->anno,
            'anno_fine' => $this->anno_fine,
            'path' => $locale . $this->path,
            'voto' => $this->voto,
            'preferito'=>$preferito
        ];
    }
}

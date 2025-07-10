<?php

namespace App\Http\Resources\v1;

use App\Models\FilmPreferiti;
use App\Models\generi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getCampi();
    }
        private function getCampi(){
            $locale = "https://www.manueldisabatino.it/stream-backend/storage/app/public/img/";
            $locale_video = "https://www.manueldisabatino.it/stream-backend/storage/app/public/video/";
            $idUser = Auth::user()->idUser;
            $preferito = FilmPreferiti::where('idUSer',$idUser)->where('idFilm',$this->idFilm)->exists();
        return [
            "idFilm"=>$this->idFilm,
            "idGenere"=>$this->idGenere,
            "genere"=>generi::where('idGenere',$this->idGenere)->valueOrFail('nome'),
            "titolo"=>$this->titolo,
            "regista"=>$this->regista,
            "durata"=>$this->durata,
            "anno"=>$this->anno,
            "path"=>$locale.$this->path_img,
            "path_video"=>$locale_video.$this->path_video,
            "trama"=>$this->trama,
            "voto"=>$this->voto,
            "generi_secondari"=>$this->generi_secondari,
            "preferito"=>$preferito
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodiResource extends JsonResource
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

    public function getCampi()
    {
        $locale = "https://www.manueldisabatino.it/stream-backend/storage/app/public/imgEpisodi/";
        $locale_video = "https://www.manueldisabatino.it/stream-backend/storage/app/public/videoEp/";  
        return [
            'idEpisodio' => $this->idEpisodio,
            'idSerie' => $this->idSerie,
            'titolo' => $this->titolo,
            'durata' => $this->durata,
            'numero' => $this->numero,
            'stagione' => $this->stagione,
            'trama'=>$this->trama,
            'voto'=> $this->voto,
            'path_img'=>$locale.$this->path_img,
            'path_video'=>$locale_video.$this->path_video
        ];
    }
}
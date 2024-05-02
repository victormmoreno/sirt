<?php

namespace App\Http\Traits\User;

use App\Models\Ocupacion;
use App\Notifications\User\CompleteTalentInformation;
use App\Values\TalentStorageValues;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait MustCompleteTalentInformation
{
    /**
     * Determine if the user has completed information talent.
     *
     * @return bool
     */
    public function hasCompletedTalentInformation()
    {
        return ! is_null($this->informacion_user_completed_at) && ! is_null($this->informacion_user);
    }

    /**
     * Mark the given user's information talent as completed.
     *
     * @return bool
     */
    public function markInformationTalentAsCompleted()
    {
        return $this->forceFill([
            'informacion_user_completed_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Mark the given user's information talent as incompleted.
     *
     * @return bool
     */
    public function markInformationTalentAsIncompleted()
    {
        return $this->forceFill([
            'informacion_user_completed_at' => null,
        ])->save();
    }

    /**
     * save information talent.
     *
     */
    public function saveInformationTalent(Request $request = null)
    {
        if(!is_null($request) && isset($request->tipo_talento))
        {
            $talentStorageClass = TalentStorageValues::TALENTTYPE[$request->tipo_talento];

            $structures =  [
                'talento' => (new $talentStorageClass)->buildStorageRecord($request)
            ];
            $this->update(['informacion_user' => $structures]);

            $this->syncOcupaciones($request);

            $this->markInformationTalentAsCompleted();
        }
    }


    /**
     * Actualizar las ocupaciones.
     */
    protected function syncOcupaciones($request)
    {
        if($request->filled('txtocupaciones')){
            $this->ocupaciones()->sync($request->get('txtocupaciones'));
        }
        if($request->filled('txtotra_ocupacion')){
            return $this->forceFill([
                "otra_ocupacion"  => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
            ])->save();
        }
        return $this;
    }


    /**
     * Send the email information talent notification.
     *
     * @return void
     */
    public function sendEmailToCompleteTalentInformation()
    {
        $this->notify(new CompleteTalentInformation);
    }

    /**
     * Get the email address that should be used for completation information talent.
     *
     * @return string
     */
    public function getEmailForCompletation()
    {
        return $this->email;
    }

    public function getInformationTalentBuilder()
    {
        if($this->isUserTalento() && isset($this->informacion_user["talento"])){
            $talentType = Str::snake(Str::lower($this->informacion_user["talento"]["tipo_talento"]));
            $talentStorageClass = TalentStorageValues::TALENTTYPE[$talentType];
            return (new $talentStorageClass)->buildResponse($this->informacion_user);
        }
    }
}

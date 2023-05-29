<?php

namespace App\Http\Traits\User;

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
        return ! is_null($this->informacion_talento_completed_at) && ! is_null($this->informacion_talento);
    }

    /**
     * Mark the given user's information talent as completed.
     *
     * @return bool
     */
    public function markInformationTalentAsCompleted()
    {
        return $this->forceFill([
            'informacion_talento_completed_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * save information talent.
     *
     */
    public function saveInformationTalent(Request $request = null)
    {
        if(!is_null($request) && isset($request->tipo_talento) && is_null($this->informacion_talento_completed_at) &&  is_null($this->informacion_talento))
        {
            $talentStorageClass = TalentStorageValues::TALENTTYPE[$request->tipo_talento];

            $structures =  [
                'talento' => (new $talentStorageClass)->buildStorageRecord($request)
            ];


            $this->update(['informacion_talento' => $structures]);

            $this->markInformationTalentAsCompleted();
        }
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
        if(isset($this->informacion_talento["talento"])){
            $talentType = Str::snake(Str::lower($this->informacion_talento["talento"]["tipo_talento"]));
            $talentStorageClass = TalentStorageValues::TALENTTYPE[$talentType];
            return (new $talentStorageClass)->buildResponse($this->informacion_talento);
        }
    }

    public function getInformationTalentEloquent()
    {
        // if(isset($this->informacion_talento["talento"])){
            return $this->informacion_talento;
        // }
    }
}

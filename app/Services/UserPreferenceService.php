<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAuthor;
use App\Models\UserCategory;
use App\Models\UserSource;
use Illuminate\Support\Facades\Auth;

class UserPreferenceService
{

    public function updatePreferences($validatedData)
    {
        $user = $this->getUserPreferences();

        $this->syncPreferences(UserSource::class, $validatedData['sources'], $user->id, $user->sources, 'source_id');
        $this->syncPreferences(UserCategory::class, $validatedData['categories'], $user->id,  $user->categories, 'category_id');
        $this->syncPreferences(UserAuthor::class, $validatedData['authors'], $user->id, $user->authors,  'author_id');
    }

    private function syncPreferences($modelClass, $newIds, $userId, $userPreference, $foreignKey)
    {
      
        $existingIds = $userPreference->pluck($foreignKey)->toArray();

        $idsToAdd = array_diff($newIds, $existingIds);
        $idsToRemove = array_diff($existingIds, $newIds);

        if ($idsToRemove) {
            $modelClass::where('user_id', $userId)->whereIn($foreignKey, $idsToRemove)->delete();
        }

        $dataToAdd = [];
        foreach ($idsToAdd as $idToAdd) {
            $dataToAdd[] = [
                'user_id' => $userId,
                $foreignKey => $idToAdd,
            ];
        }
        $modelClass::insert($dataToAdd);
    }

    public function getUserPreferences() {
        return User::where('id', Auth::id())
            ->select('id', 'name', 'email')
            ->with([
                'sources.source:id,name',            
                'categories.category:id,name',      
                'authors.author:id,name'            
            ])->first();
    }
    
    
}

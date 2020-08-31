<?php

    namespace App\Http\Controllers;


    use App\Activity;
    use App\User;
    use Illuminate\Database\Eloquent\Collection;

    class ProfilesController extends Controller
    {
        public function show(User $user)
        {
            //            return $activities;

            return view('profiles.show', [
                'profileUser' => $user,
//                'activities' => $this->getActivity($user)
                'activities' => Activity::feed($user)
            ]);
        }

        /**
         * @param \App\User $user
         * @return \Illuminate\Database\Eloquent\Collection
         */
        protected function getActivity(User $user): Collection
        {
            return $user->activity()->latest()->with('subject')->take(50)->get()->groupBy(function($activity){
                return $activity->created_at->format('Y-m-d');
            });
        }
    }

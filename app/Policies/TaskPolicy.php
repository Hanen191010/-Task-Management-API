<?php

 namespace App\Policies;

 use App\Models\Task;
 use App\Models\User;
 use Illuminate\Auth\Access\HandlesAuthorization;

 class TaskPolicy
 {
     use HandlesAuthorization; /**
  * Determine whether the user can view any models.
  *
  * @param \App\Models\User $user
  * @return mixed
  */
 public function viewAny(User $user)
 {
     return $user->role === 'admin' || $user->role === 'manager';
 }

 /**
  * Determine whether the user can view the model.
  *
  * @param \App\Models\User $user
  * @param \App\Models\Task $task
  * @return mixed
  */
 public function view(User $user, Task $task)
 {
     return $user->role === 'admin' || $use->role === 'manager' || $task->assigned_to === $user->id;
 }

 /**
  * Determine whether the user can create models.
  *
  * @param \App\Models\User $user
  * @return mixed
  */
 public function create(User $user)
 {
     return $user->role === 'admin' || $user->role === 'manager';
 }

 /**
  * Determine whether the user can update the model.
  *
  * @param \App\Models\User $user
  * @param \App\Models\Task $task
  * @return mixed
  */
 public function update(User $user, Task $task)
 {
     return $user->role === 'admin' || $user->role === 'manager' || ($user->role === 'user' && $task->assigned_to === $user->id);
 }

 /**
  * Determine whether the user can delete the model.
  *
  * @param \App\Models\User $user
  * @param \App\Models\Task $task
  * @return mixed
  */
 public function delete(User $user, Task $task)
 {
     return $user->role === 'admin' || $user->role === 'manager';
 }

 /**
  * Determine whether the user can restore the model.
  *
  * @param \App\Models\User $user
  * @param \App\Models\Task $task
  * @return mixed
  */
 public function restore(User $user, Task $task)
 {
     return $user->role === 'admin' || $user->role === 'manager';
 }

 /**
  * Determine whether the user can permanently delete the model.
  *
  * @param \App\Models\User $user
  * @param \App\Models\Task $task
  * @return mixed
  */
 public function forceDelete(User $user, Task $task)
 {
     return $user->role === 'admin' || $user->role === 'manager';
 }
 }
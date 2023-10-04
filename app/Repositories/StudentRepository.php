<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\StudentOptions;
use App\Models\User;
use App\Models\CompanySubscription;
use App\Models\UserDetails;
use App\Http\Requests\Web\StudentUpdateRequest;
use App\Interfaces\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class StudentRepository implements StudentRepositoryInterface
{
    protected $userModel;
    protected $userRepository;

    public function __construct(User $userModel, UserRepositoryInterface $userRepository)
    {
        $this->userModel = $userModel;
        $this->userRepository = $userRepository;
    }

    public function getStudent(string $id): Model|Collection|Builder|array|null
    {
        return $this->userModel->with(['userDetails', 'studentOptions', 'companySubscription'])->find($id);
    }

    public function update(array $studentData) : bool|null
    {
        $user = $this->getStudent($studentData['id']);
        $this->updateUserDetails($user, $studentData);
        $this->updateUserStatus($user, $studentData);
        $this->updateStudentOptions($user, $studentData);
        $this->updateCompanySubscription($user, $studentData);
        return $user->push();
    }

    private function updateUserDetails($user, array $studentData): void
    {
        $user->firstname = $studentData['firstname'];
        $user->lastname = $studentData['lastname'];
        $user->email = $studentData['email'];
        $user->userDetails->mobile = $studentData['mobile_no'];
    }

    private function updateUserStatus($user, array $studentData): void
    {
        $user->is_active = $studentData['is_active'] ?? false;
    }

    private function updateStudentOptions($user, array $studentData): void
    {
        $user->studentOptions->has_email_notification = $studentData['has_email_notification'] ?? false;
        $user->studentOptions->has_gift_sessions = $studentData['has_gift_sessions'] ?? false;
        $user->studentOptions->has_recurring_gift_sessions = $studentData['has_recurring_gift_sessions'] ?? false;
        $user->studentOptions->has_free_unlimited_sessions = $studentData['has_free_unlimited_sessions'] ?? false;
        $user->studentOptions->has_free_recurring_sessions_for_company = $studentData['has_free_recurring_sessions_for_company'] ?? false;
        $user->studentOptions->has_free_sessions_for_company = $studentData['has_free_sessions_for_company'] ?? false;
        $user->studentOptions->count_trial_sessions = $studentData['count_trial_sessions'] ?? 0;
        $user->studentOptions->count_gift_sessions = $studentData['count_gift_sessions'] ?? 0;
        $user->studentOptions->count_recurring_gift_sessions = $studentData['count_recurring_gift_sessions'] ?? 0;
        $user->studentOptions->count_company_sessions = $studentData['count_company_sessions'] ?? 0;
        $user->studentOptions->company_id = $studentData['company_id'] ?? null;
    }

    private function updateCompanySubscription($user, array $studentData): void
    {
        if (!$user->studentOptions->has_free_recurring_sessions_for_company || !$studentData['plan_id']) {
            return;
        }

        CompanySubscription::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'plan_id' => $studentData['plan_id'],
                'company_id' => $user->studentOptions->company_id,
                'type' => 'MONTHLY',
                'is_active' => false,
                'is_paused' => false,
                'start_date' => $user->companySubscription->start_date ?? now(),
                'end_date' => $user->companySubscription->start_date ?? now(),
                'count_used_sessions' => $user->companySubscription->count_used_sessions ?? 0
            ]
        );
    }

    public function delete(string $id) : bool
    {
        return $this->userModel->findOrFail($id)->delete();
    }
}

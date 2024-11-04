<?php

namespace App\Constants;

class ApplicationStatus
{
    const SUBMITTED = 'Submitted';
    const UNDER_REVIEW = 'Under Review';
    const INTERVIEW_SCHEDULED = 'Interview Scheduled';
    const INTERVIEWED = 'Interviewed';
    const SHORTLISTED = 'Shortlisted';
    const OFFERED = 'Offered';
    const ACCEPTED = 'Accepted';
    const DECLINED = 'Declined';
    const HIRED = 'Hired';
    const NOT_SELECTED = 'Not Selected';
    const WITHDRAWN = 'Withdrawn';
    const CLOSED = 'Closed';

    public static function getStatuses(): array
    {
        return [
            self::SUBMITTED,
            self::UNDER_REVIEW,
            self::INTERVIEW_SCHEDULED,
            self::INTERVIEWED,
            self::SHORTLISTED,
            self::OFFERED,
            self::ACCEPTED,
            self::DECLINED,
            self::HIRED,
            self::NOT_SELECTED,
            self::WITHDRAWN,
            self::CLOSED,
        ];
    }
}

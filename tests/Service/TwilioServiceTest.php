namespace App\Tests\Service;

use App\Service\TwilioService;
use PHPUnit\Framework\TestCase;
use Twilio\Rest\Client;
use Twilio\Rest\Verify\V2\Service\VerificationInstance;
use Twilio\Rest\Verify\V2\Service\VerificationCheckInstance;

class TwilioServiceTest extends TestCase
{
public function testStartVerification(): void
{
// Mock Twilio Client
$twilioClientMock = $this->createMock(Client::class);

// Mock the verify service and verifications method
$verifyServiceMock = $this->createMock(VerificationInstance::class);
$twilioClientMock->verify = (object)[
'v2' => (object)[
'services' => function () use ($verifyServiceMock) {
return (object)[
'verifications' => (object)[
'create' => function ($to, $channel) {
return true; // Simulate successful creation
},
],
];
},
],
];

// Initialize TwilioService with mocked client
$twilioService = new TwilioService('test_sid', 'test_auth_token', 'test_service_sid');
$result = $twilioService->startVerification('+1234567890', 'sms');

// Assert that the result is true
$this->assertTrue($result);
}

public function testCheckVerification(): void
{
// Mock Twilio Client
$twilioClientMock = $this->createMock(Client::class);

// Mock the verify service and verificationChecks method
$verificationCheckMock = $this->createMock(VerificationCheckInstance::class);
$verificationCheckMock->status = 'approved'; // Simulate an approved status

$twilioClientMock->verify = (object)[
'v2' => (object)[
'services' => function () use ($verificationCheckMock) {
return (object)[
'verificationChecks' => (object)[
'create' => function ($params) use ($verificationCheckMock) {
return $verificationCheckMock;
},
],
];
},
],
];

// Initialize TwilioService with mocked client
$twilioService = new TwilioService('test_sid', 'test_auth_token', 'test_service_sid');
$result = $twilioService->checkVerification('+1234567890', '123456');

// Assert that the result is true
$this->assertTrue($result);
}
}

1. Để test được trường hợp exception phía controller cần đảm bảo throw ra nếu có lỗi
2. Phía test sẻ mong đợi tên exception đó + message và tái hiện lại trường hợp xảy ra exception
3. Exception message sẻ true nếu phản hồi có CHỨA  nội dung lỗi chứ không phải hoàn toàn chuỗi đó

class TestController extends Controller							
{							
    private  $password;							
							
    public function setPassword($password)							
    {							
        if (strlen($password) < 8) {							
            throw new \Exception('Mật khẩu phải lớn hơn 8 kí tự');							
        }							
							
        $this->password = $password;							
    }							
}							

public function testExceptionAreThrownForShortPasswords()	
{	
    $test = new TestController();	
    $test->setPassword('1234567');	
}	



php .\vendor\bin\phpunit .\tests\Unit\ExampleTest.php
1) Tests\Unit\ExampleTest::testExceptionAreThrownForShortPasswords
Exception: Mật khẩu phải lớn hơn 8 kí tự

===========================Dùng Throw ném ra 1 ngoại lệ=================================================================
    public function setPassword($password)							
    {							
        if (strlen($password) < 8) {							
            throw new \InvalidArgumentException('Mật khẩu phải lớn hơn 8 kí tự');							
        }							
							
        $this->password = $password;							
    }							

    public function testExceptionAreThrownForShortPasswords()	
    {	
        $test = new TestController();	
        $this->expectException(\InvalidArgumentException::class);	
        $this->expectExceptionMessage('Mật khẩu phải lớn hơn 8 kí tự');	
        $test->setPassword('1234567');	
    }	
    
php .\vendor\bin\phpunit .\tests\Unit\ExampleTest.php
1) Tests\Unit\ExampleTest::testExceptionAreThrownForShortPasswords
InvalidArgumentException: Mật khẩu phải lớn hơn 8 kí tự
OK (2 tests, 3 assertions)

========================Throw======================Dùng try catch=====================
h					

class TestController extends Controller										
{										
    private  $password;										
    private  const EXCLUDED_CHARS = '@';										
										
    public function setPassword($password)										
    {										
        if (strlen($password) < 8 || SELF::EXCLUDED_CHARS) {										
            throw new \InvalidArgumentException										
            ('Mật khẩu phải lớn hơn 8 kí tự và không được chứa kí tự đặc biệt');										
        }										
										
        $this->password = $password;										
    }										
}										
										
Cũng có thể dùng hàm này chỉ để check nội dung đó có chứa trong getMessage					
$this->assertStringContainsString('kí tự đặc biệt', $e->getMessage());										

    public function testExceptionThrownIfPassContainsExcludeWords()									
    {									
        try{									
            $test = new TestController();									
            $test->setPassword('12@34567');									
        }catch(\InvalidArgumentException $e){									
            $this->assertEquals									
            (									
                'Mật khẩu phải lớn hơn 8 kí tự và không được chứa kí tự đặc biệt',									
                $e->getMessage()									
            );									
        }									
    }									
============================================Lỗi ngoại lệ khi truy cập vào 1 user không hợp lệ			
• 						
    public function testFindUserById()									
    {									
        $this->expectException(\Exception::class);									
									
        $userId = 999; // ID người dùng không tồn tại trong cơ sở dữ liệu									
        $user = User::findOrFail($userId);									
									
        //Call to a member function connection() on null									
        $this->assertNotNull($user->connection());									
									
    }									
									
====================================================Khẳng định có ngoại lệ khi truy cập vào 1 key không tồn tại trong controller

    public function responseData()	
    {	
        try {	
            $data = [	
                'name' => 'Nguyễn Văn A',	
                'age' => 20	
            ];	
	
            $address = $data['address']; // Truy cập khóa không tồn tại	
	
            return response()->json([	
                'status' => 'success',	
                'message' => 'Thành công',	
                'data' => $data	
            ]);	
        } catch (\Exception $e) {	
            return $e;	
        }	
    }	



    public function testResponseDataException()	
    {	
        $test = new TestController();	
	
        $data = $test->responseData();	
        //khẳng định rằng $data là một đối tượng của lớp Exception	
        $this->assertInstanceOf(\Exception::class, $data);	
        //khẳng định rằng $data->getMessage() trả về chuỗi 'Undefined array key "address"'	
        $this->assertStringContainsString('Undefined array key ', $data->getMessage());	
    }	


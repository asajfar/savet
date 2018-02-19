<?php

require_once 'dbconfig.php';

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	//executes a Query
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	//return a last insert id
	public function lastID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	//register new user
	public function register($fname,$lname,$location,$street,$mobile,$email,$uname,$upass,$code)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_members(memberName,memberLastname,memberLocation,memberStreet,memberMobile,memberEmail,memberUsername,memberPassword,tokenCode) 
			                                             VALUES(:member_firstname, :member_lastname, :member_location, :member_street, :member_mobile, :member_mail, :member_username, :member_password, :active_code)");
			$stmt->bindparam(":member_firstname",$fname);
			$stmt->bindparam(":member_lastname",$lname);
			$stmt->bindparam(":member_location",$location);
			$stmt->bindparam(":member_street",$street);
			$stmt->bindparam(":member_mobile",$mobile);
			$stmt->bindparam(":member_mail",$email);
			$stmt->bindparam(":member_username",$uname);
			$stmt->bindparam(":member_password",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	//upis komentara
	public function komentar($memberID,$oblast,$komentar,$date)
	{
		try
		{							
			$stmt = $this->conn->prepare("INSERT INTO tbl_comments(memberID,commentSection,commentContent,commentDate) 
			                                             VALUES(:member_ID, :comment_section, :comment_content, :comment_date)");
			$stmt->bindparam(":member_ID",$memberID);
			$stmt->bindparam(":comment_section",$oblast);
			$stmt->bindparam(":comment_content",$komentar);
			$stmt->bindparam(":comment_date",$date);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	//izmena podataka
	public function podaci($memberID,$fname,$lname,$location,$street,$mobile)
	{
		try
		{							
			$stmt = $this->conn->prepare("UPDATE tbl_members SET memberName = :member_firstname,
																 memberLastname = :member_lastname,
																 memberLocation = :member_location,
																 memberStreet = :member_street,
																 memberMobile = :member_mobile
														   WHERE memberID = :member_ID");
			                                            
			$stmt->bindparam(":member_ID",$memberID);
			$stmt->bindparam(":member_firstname",$fname);
			$stmt->bindparam(":member_lastname",$lname);
			$stmt->bindparam(":member_location",$location);
			$stmt->bindparam(":member_street",$street);
			$stmt->bindparam(":member_mobile",$mobile);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	//to login user
	public function login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_members WHERE memberEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$memberRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($memberRow['memberStatus']=="Y")
				{
					if($memberRow['memberPassword']==md5($upass))
					{
						$_SESSION['memberSession'] = $memberRow['memberID'];
						return true;
					}
					else
					{
						header("Location: clanstvo.php?error");
						exit;
					}
				}
				else
				{
					header("Location: clanstvo.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: clanstvo.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	//to login admin
	public function loginadmin($korisnik,$lozinka,$pin)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_panel WHERE korisnikName=:name_id");
			$stmt->execute(array(":name_id"=>$korisnik));
			$korisnikRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{				
				if(($korisnikRow['korisnikPassword']==md5($lozinka)) && ($korisnikRow['korisnikPin']==$pin))
				{
					$_SESSION['korisnikSession'] = $korisnikRow['korisnikID'];
					return true;
				}
				else
				{
					header("Location: index.php?error");
					exit;
				}
			}
			else
			{
				header("Location: index.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	

	//return users session is active or not za ADMIN sesiju
	public function is_logged_in_admin()
	{
		if(isset($_SESSION['korisnikSession']))
		{
			return true;
		}
	}


	// to destroy users session u ADMIN sesiji
	public function logout_admin()
	{
		session_destroy();
		$_SESSION['korisnikSession'] = false;
	}
	

	//return users session is active or not
	public function is_logged_in()
	{
		if(isset($_SESSION['memberSession']))
		{
			return true;
		}
	}
	

	public function redirect($url)
	{
		header("Location: $url");
	}
	

	// to destroy users session
	public function logout()
	{
		session_destroy();
		$_SESSION['memberSession'] = false;
	}
	
	//to send mail at user registration and send forgot password reset link
	function send_mail($email,$message,$subject)
	{					
		require('mailer/PHPMailerAutoload.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "mail.sbsns.rs";      
		$mail->Port       = 465;             
		$mail->AddAddress($email);
		$mail->Username="registracija@sbsns.rs";  
		$mail->Password="regsavet1379";            
		$mail->SetFrom('registracija@sbsns.rs','Savet za bezbednost saobracaja Novi Sad');
		$mail->AddReplyTo("registracija@sbsns.rs","Savet za bezbednost saobracaja Novi Sad");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}

	//to send mail at registered users
	function send_mail_admin($email,$message,$subject)
	{					
		require('../../sbsnsdb/mailer/PHPMailerAutoload.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "mail.sbsns.rs";      
		$mail->Port       = 465;             
		$mail->AddAddress($email);
		$mail->Username="registracija@sbsns.rs";  
		$mail->Password="regsavet1379";            
		$mail->SetFrom('registracija@sbsns.rs','Savet za bezbednost saobracaja Novi Sad');
		$mail->AddReplyTo("registracija@sbsns.rs","Savet za bezbednost saobracaja Novi Sad");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}		
}
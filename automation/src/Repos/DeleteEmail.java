package Repos;
import javax.net.ssl.SSLEngineResult.HandshakeStatus;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class DeleteEmail extends BasePage {



	private static String Url = "login";





	public static void GoToPage(WebDriver driver) {		
		//BasePage.GoToPageUrl(driver, Url);
		//LoginPage.LoginAsAdmin(driver);
		AdminHome.DeleteEmail(driver).click();
	}


//check to see if the email exists on a page
	
	public static boolean hasEmail(String email, WebDriver driver1)
	{
		if(driver1.findElement(By.tagName("body")).getText().contains(email))
		{
			System.out.println("true");
			return true;
		}
		else
		{
			System.out.println("false");
			return false;
		}
	}
	//check to see if the email is a student or a instructor

	public static String isStudent(String email,WebDriver driver2)
	{
		if(driver2.findElement(By.id("students")).getText().contains(email))
		{
			System.out.println("students");

			return "Student";
		}
		else if(driver2.findElement(By.id("instructors")).getText().contains(email))
		{

			System.out.println("students");
			return "instructor";
		}
		else
		{
			System.out.println("not found");
			return "notfound";
		}



	}



}






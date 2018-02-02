package Tests;

import java.sql.Driver;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.Test;

import Repos.DeleteEmail;
import Repos.LoginPage;

public class AdminHomeTest extends BaseTest {
	
	
	public AdminHomeTest() {
		super();	
		String email="admin@wechart.com";
		System.out.println("got here 1");
		
		driver.findElement(By.id("email")).sendKeys("admin@wechart.com");
		driver.findElement(By.id("password")).sendKeys("wechartadmin");
		driver.findElement(By.cssSelector("button[type='submit']")).click();
		DeleteEmail.GoToPage(driver);
		DeleteEmail.hasEmail("astril@gmail.com", driver);
		DeleteEmail.isStudent("astril@gmail.com", driver);
		
	}
	//WebDriver driver =  new FirefoxDriver();

	
 
	
  @Test
  public boolean StudentExists(String email)
	{
	  if(driver.findElement(By.tagName("body")).getText().contains(email))
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
}

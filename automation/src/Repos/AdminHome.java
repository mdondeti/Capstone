package Repos;

import java.sql.Driver;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class AdminHome extends BasePage{

private static String Url = "/home";
	
	public static void GoToPage(WebDriver driver) {
		BasePage.GoToPageUrl(driver, Url);
	}
	
	public static WebElement AdminDashboardName(WebDriver driver) {
		return driver.findElement(By.tagName("h3"));
	}
	
	public static WebElement AdminLogOutStep1(WebDriver driver) {
		return driver.findElement(By.xpath("//a[@href='#']"));
		
		
		
	}	
	
	
	public static WebElement DeleteEmail(WebDriver driver)
	{
		return driver.findElement(By.partialLinkText("Remove Emails"));
	}
	//takes in email to check if it exists on the admin dashboard
	//only registered emails exist on admin dashboard
	
	public static boolean hasEmail(String email, WebDriver driver)
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

package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class layoutPage {
	
	
	public static WebElement dropdown(WebDriver driver) {
		return driver.findElement(By.className("caret"));
	}
	
	public static WebElement logout(WebDriver driver) {
		return driver.findElement(By.partialLinkText("Logout"));
	}
	
	public static WebElement editProfile(WebDriver driver) {
		return driver.findElement(By.partialLinkText("Edit Profile"));
	}
	
	public static WebElement role(WebDriver driver) {
		return driver.findElement(By.id("role"));
	}
	
	
//	public static WebElement UserName(WebDriver driver) {
//		return driver.findElement(By.id("email"));
//	}
//	
//	public static WebElement UserName(WebDriver driver) {
//		return driver.findElement(By.id("email"));
//	}
//	
//	public static WebElement UserName(WebDriver driver) {
//		return driver.findElement(By.id("email"));
//	}
//	
//	public static WebElement UserName(WebDriver driver) {
//		return driver.findElement(By.id("email"));
//	}
//	
	

}

package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class forgotPasswordPage {
	
private static String Url = "password/reset";
	
	public static void GoToPage(WebDriver driver) {
		BasePage.GoToPageUrl(driver, Url);
	}
	public static WebElement email(WebDriver driver) {
		return driver.findElement(By.id("age"));
	}
	
	
	public static WebElement randomQuestion(WebDriver driver) {
		return driver.findElement(By.id("randomQuestionNumber"));
	}
	public static WebElement randomAnswer(WebDriver driver) {
		return driver.findElement(By.id("security_answer2"));
	}
	
}

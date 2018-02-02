package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class addStudentEmailPage extends BasePage{

private static String Url = "AddStudentEmails";
	
	public static void GoToPage(WebDriver driver) {
		BasePage.GoToPageUrl(driver, Url);
	}
	
	public static WebElement addButton(WebDriver driver) {
		return driver.findElement(By.partialLinkText("Add row"));
	}
	
	public static WebElement Email(WebDriver driver) {
		return driver.findElement(By.id("email[]"));
	}
	
	
	public static WebElement backToDashboard(WebDriver driver) {
		return driver.findElement(By.partialLinkText("Back to Dashboard"));
	}
	
	public static WebElement Save(WebDriver driver) {
		return driver.findElement(By.xpath("//button[@type='submit']"));
	}
	

}

package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class StudentHome extends BasePage {

	public StudentHome() {
		super();
	}
	
	public static WebElement StudentDashboardName(WebDriver driver) {
		return driver.findElement(By.tagName("h3"));
	}
	
	public static WebElement StudentLogOutStep1(WebDriver driver) {
		return driver.findElement(By.xpath("//a[@href='#']"));
	}
	
	public static WebElement StudentLogOutStep2(WebDriver driver) {
		return driver.findElement(By.linkText("Logout"));
	}
}

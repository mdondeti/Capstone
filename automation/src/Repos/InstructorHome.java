package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class InstructorHome extends BasePage{

	public InstructorHome() {
		super();
	}
	
	public static WebElement InstructorDashboardName(WebDriver driver) {
		return driver.findElement(By.tagName("h3"));
	}
	
	public static WebElement InstructorLogOutStep1(WebDriver driver) {
		return driver.findElement(By.xpath("//a[@href='#']"));
	}
	
	public static WebElement InstructorLogOutStep2(WebDriver driver) {
		return driver.findElement(By.linkText("Logout"));
	}
}

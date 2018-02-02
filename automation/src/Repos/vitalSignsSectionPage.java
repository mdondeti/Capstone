package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class vitalSignsSectionPage  {

	
	public static WebElement ageDemo(WebDriver driver) {
		return driver.findElement(By.id("age"));
	}
	
	public static WebElement nameDemo(WebDriver driver) {
		return driver.findElement(By.id("name"));
	}
	
	public static WebElement sexDemo(WebDriver driver) {
		return driver.findElement(By.id("sex"));
	}
	public static WebElement backToDash(WebDriver driver) {
		return driver.findElement(By.partialLinkText("Back to Dashboard"));
	}
	
	public static WebElement roomNo(WebDriver driver) {
		return driver.findElement(By.id("room_number"));
	}
	
	public static WebElement visitDate(WebDriver driver) {
		return driver.findElement(By.id("visit_date"));
	}
	public static WebElement temp(WebDriver driver) {
		return driver.findElement(By.id("temperature"));
	}
	
	public static WebElement pain(WebDriver driver) {
		return driver.findElement(By.id("pain"));
	}
	
	public static WebElement heartRate(WebDriver driver) {
		return driver.findElement(By.id("heart_rates"));
	}
	
	public static WebElement bpsystolic(WebDriver driver) {
		return driver.findElement(By.id("bp_systolic"));
	}
	
	public static WebElement bpdiastolic(WebDriver driver) {
		return driver.findElement(By.id("bp_diastolic"));
	}
	
	public static WebElement RespRate(WebDriver driver) {
		return driver.findElement(By.id("respiratory_rate"));
	
}
	public static WebElement oxygenSaturation(WebDriver driver) {
		return driver.findElement(By.id("oxygen_saturation"));
	
}
	
	
	
	
	
	
}

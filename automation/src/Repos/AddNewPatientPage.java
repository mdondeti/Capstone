package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class AddNewPatientPage extends BasePage{
	
	private static String Url = "/add_patient";
	
	
	public static void GoToPage(WebDriver driver) {
		BasePage.GoToPageUrl(driver, Url);
	}
	public static WebElement MaleRadioButton(WebDriver driver) {
		return driver.findElement(By.id("genderMale"));
	}
	public static WebElement FemaleRadioButton(WebDriver driver) {
		return driver.findElement(By.id("genderFemale"));
	}
	
	public static WebElement genderError(WebDriver driver) {
		return driver.findElement(By.id("genderError"));
	}
	public static WebElement ModuleDropdown(WebDriver driver)
	{
		return driver.findElement(By.name("module_id"));
	}	
	public static WebElement moduleError(WebDriver driver) {
		return driver.findElement(By.id("moduleError"));
	}
	public static WebElement roomNumber(WebDriver driver)
	{
		return driver.findElement(By.id("room_number"));
	}
	
	public static WebElement ageTextBox(WebDriver driver)
	{
		return driver.findElement(By.id("age"));
	}
	public static WebElement ageError(WebDriver driver) {
		return driver.findElement(By.id("ageError"));
	}
	public static WebElement heightTextBox(WebDriver driver)
	{
		return driver.findElement(By.id("height"));	
		
	}
	public static WebElement heihtError(WebDriver driver) {
		return driver.findElement(By.id("heightError"));
	}
	public static WebElement heightUnitDropDown(WebDriver driver)
	{
		return driver.findElement(By.name("height_unit"));	
		
	}
	public static WebElement weightTextBox(WebDriver driver)
	{
		return driver.findElement(By.id("weight"));	
		
	}
	public static WebElement weightError(WebDriver driver) {
		return driver.findElement(By.id("weightError"));
	}
	public static WebElement weightUnitDropDown(WebDriver driver)
	{
		return driver.findElement(By.name("weight_unit"));	
		
	}
	public static WebElement VisitDateTextBox(WebDriver driver)
	{
		return driver.findElement(By.id("visit_date"));	
		
	}
	public static WebElement visitDateError(WebDriver driver) {
		return driver.findElement(By.id("visitDateError"));
	}
	public static WebElement alert(WebDriver driver)
	{
		return driver.findElement(By.id("errors"));	
		
	}
	
	public static WebElement Submit(WebDriver driver) {
		return driver.findElement(By.cssSelector("button[type='submit']"));
	}
		

}

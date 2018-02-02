package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class vitalSignsPage  {

	
	public static WebElement BPS(WebDriver driver) {
		return driver.findElement(By.id("BP_Systolic"));
	}


	public static WebElement BPD(WebDriver driver) {
		return driver.findElement(By.id("BP_Diastolic"));
	}


	public static WebElement heartRate(WebDriver driver) {
		return driver.findElement(By.id("Heart_Rate"));
	}


	public static WebElement respRate(WebDriver driver) {
		return driver.findElement(By.id("Respiratory_Rate"));
	}


	public static WebElement temp(WebDriver driver) {
		return driver.findElement(By.id("Temperature"));
	}


	public static WebElement temp_Unit(WebDriver driver) {
		return driver.findElement(By.id("temperature_unit"));
	}


	public static WebElement weight(WebDriver driver) {
		return driver.findElement(By.id("Weight"));
	}


	public static WebElement weightUnit(WebDriver driver) {
		return driver.findElement(By.id("weight_unit"));
	}


	public static WebElement height(WebDriver driver) {
		return driver.findElement(By.id("Height"));
	}


	public static WebElement heightUnit(WebDriver driver) {
		return driver.findElement(By.id("height_unit"));
	}


	public static WebElement pain(WebDriver driver) {
		return driver.findElement(By.id("Pain"));
	}


	public static WebElement oSaturation(WebDriver driver) {
		return driver.findElement(By.id("Oxygen_Saturation"));
	}


	public static WebElement comment(WebDriver driver) {
		return driver.findElement(By.id("Comments"));
		
	}


//	public static WebElement submit(WebDriver driver) {
//		return driver.findElement(By.xpath("//button[@class='btn btn-success btn-submit btn-sm']"));
//	}
	
	public static WebElement childsubmit(WebDriver driver) {
		return driver.findElement(By.id("childAdd"));
	}
	

	public static WebElement addVital(WebDriver driver) {
		return driver.findElement(By.id("btn_add_vital_signs"));
	}

	public static WebElement table(WebDriver driver) {
		return driver.findElement(By.id("vital_signs_table"));
	}
		
	public static WebElement addTable(WebDriver driver) {
		return driver.findElement(By.id("table_child_vital_signs"));
	}
	
	
}

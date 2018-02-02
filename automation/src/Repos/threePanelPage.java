package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class threePanelPage {
	
	public static WebElement MedicalHistory(WebDriver driver) {
		return driver.findElement(By.id("Medical History_tab"));
	}
	
	public static WebElement demographicsTb(WebDriver driver) {
		return driver.findElement(By.id("Demographics_tab"));
	}
	
	public static WebElement hpiTab(WebDriver driver) {
		return driver.findElement(By.id("History of Present Illness (HPI)_tab"));
	}
	
	public static WebElement medicationsTab(WebDriver driver) {
		return driver.findElement(By.id("Medications_tab"));
	}
	
	public static WebElement vitalSignsTab(WebDriver driver) {
		return driver.findElement(By.id("Vital Signs_tab"));
	}
	
	
	public static WebElement rosTab(WebDriver driver) {
		return driver.findElement(By.id("Review of System (ROS)_tab"));
	}
	
	
	public static WebElement physicalExam(WebDriver driver) {
		return driver.findElement(By.id("Physical Exam_tab"));
	}
	
	
	public static WebElement ordersTab(WebDriver driver) {
		return driver.findElement(By.id("Orders_tab"));
	}
	
	
	public static WebElement resultsTab(WebDriver driver) {
		return driver.findElement(By.id("Results_tab"));
	}
	
	
	public static WebElement dispositionTab(WebDriver driver) {
		return driver.findElement(By.id("Disposition_tab"));
	}
	
	public static WebElement backToDashboard(WebDriver driver) {
		return driver.findElement(By.id("back_to_dashboard"));
	}
	
	
	
	
	
	
	

}

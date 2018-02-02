package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class MedicationsPage {
	
	
	public static WebElement MedicationsComment(WebDriver driver) {
		return driver.findElement(By.id("medication_comment"));
	}
	
	public static WebElement saveMedications(WebDriver driver) {
		return driver.findElement(By.id("btn_save_medication"));
	}
	
	
	public static WebElement menuMedications(WebDriver driver) throws Exception {
		//var element = driver.FindElement(By.Id(id)).FindElement(By.XPath("following-sibling::*[1]"));
		  
Thread.sleep(5000);
		 //return driver.findElement(By.id("search_diagnosis_personal_history")).findElement(By.xpath("following-sibling::*[1]"));
		 WebElement selectbox = driver.findElement(By.id("search_medications")).findElement(By.xpath("following-sibling::*[1]"));;
		 //element.Click();
		 return selectbox.findElement(By.cssSelector("input[type=search]"));		
		 
	}	
	
	
	
	

}

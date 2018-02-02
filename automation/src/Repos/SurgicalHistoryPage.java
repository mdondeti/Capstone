package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class SurgicalHistoryPage {
	
	public static WebElement SurgicalComment(WebDriver driver) {
		return driver.findElement(By.id("surgical_history_comment"));
	}
	
	public static WebElement SurgicalSave(WebDriver driver) {
		return driver.findElement(By.id("btn_save_surgical_history"));
	}
	public static WebElement menuDemographics(WebDriver driver) throws Exception {
		//var element = driver.FindElement(By.Id(id)).FindElement(By.XPath("following-sibling::*[1]"));
		  
Thread.sleep(5000);
		 //return driver.findElement(By.id("search_diagnosis_personal_history")).findElement(By.xpath("following-sibling::*[1]"));
		 WebElement selectbox = driver.findElement(By.id("search_diagnosis_surgical_history")).findElement(By.xpath("following-sibling::*[1]"));;
		 //element.Click();
		 return selectbox.findElement(By.cssSelector("input[type=search]"));		
		 
	}	
	
	
	
}

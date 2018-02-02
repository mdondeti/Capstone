package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class FamilyHistoryPage {

	
	
	
	public static WebElement addFamilyMember(WebDriver driver) {
		return driver.findElement(By.id("add_family_member"));
		
	}
	public static WebElement relation(WebDriver driver) {
		return driver.findElement(By.id("relation_family_history"));
		
			
	}
	public static WebElement AliveYes(WebDriver driver) {
		return driver.findElement(By.id("family_member_status_yes"));
		
	}
	public static WebElement AliveNo(WebDriver driver) {
		return driver.findElement(By.id("family_member_status_no"));
		
	}
	public static WebElement save(WebDriver driver) {
		return driver.findElement(By.id("btn_save_new_family_member"));
		
	}
	public static WebElement familyHistoryComment(WebDriver driver) {
		return driver.findElement(By.id("family_history_comment"));
		
	}
	public static WebElement cancel(WebDriver driver) {
		return driver.findElement(By.id("btn_cancel_new_family_member"));
		
	}
	public static WebElement saveComment(WebDriver driver) {
		return driver.findElement(By.id("family_history_comment"));
		
	}
	public static WebElement tableFamilyHistory(WebDriver driver) {
		return driver.findElement(By.id("table_family_history"));
		
	}
	public static WebElement menuDemographics(WebDriver driver) throws Exception {
		//var element = driver.FindElement(By.Id(id)).FindElement(By.XPath("following-sibling::*[1]"));
		  
Thread.sleep(5000);
		 //return driver.findElement(By.id("search_diagnosis_personal_history")).findElement(By.xpath("following-sibling::*[1]"));
		 WebElement selectbox = driver.findElement(By.id("search_diagnosis_list_family_history")).findElement(By.xpath("following-sibling::*[1]"));;
		 //element.Click();
		 return selectbox.findElement(By.cssSelector("input[type=search]"));		
		 
	}	
	
	
	
}

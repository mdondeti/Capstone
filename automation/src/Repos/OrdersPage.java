package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class OrdersPage {
	
	
	
	public static WebElement ordersComments(WebDriver driver) {
		return driver.findElement(By.id("orders_comment"));
	}
	
	public static WebElement saveOrders(WebDriver driver) {
		return driver.findElement(By.id("btn_save_orders"));
	}
	
	public static WebElement menuLabs(WebDriver driver) throws Exception {
		//var element = driver.FindElement(By.Id(id)).FindElement(By.XPath("following-sibling::*[1]"));
		  
Thread.sleep(5000);
		 //return driver.findElement(By.id("search_diagnosis_personal_history")).findElement(By.xpath("following-sibling::*[1]"));
		 WebElement selectbox = driver.findElement(By.id("search_labs_orders")).findElement(By.xpath("following-sibling::*[1]"));;
		 //element.Click();
		 return selectbox.findElement(By.cssSelector("input[type=search]"));		
		 
	}	
	public static WebElement menuImages(WebDriver driver) throws Exception {
		//var element = driver.FindElement(By.Id(id)).FindElement(By.XPath("following-sibling::*[1]"));
		  
Thread.sleep(5000);
		 //return driver.findElement(By.id("search_diagnosis_personal_history")).findElement(By.xpath("following-sibling::*[1]"));
		 WebElement selectbox = driver.findElement(By.id("search_labs_imaging")).findElement(By.xpath("following-sibling::*[1]"));;
		 //element.Click();
		 return selectbox.findElement(By.cssSelector("input[type=search]"));		
		 
	}	
	
	
	
	
	

}
